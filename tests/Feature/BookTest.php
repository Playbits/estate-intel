<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BookTest extends TestCase {

    use RefreshDatabase;

    protected $book_url = "/api/v1/books";
    protected $book_data = [
        "name" => "A game of thrones",
        "isbn" => "009-0553103540",
        "authors" => ["john doe"],
        "number_of_pages" => 350,
        "publisher" => "Ace",
        "country" => "USA",
        "release_date" => "1999-08-01",
    ];
    /**
     * A basic test for external books
     *
     * @return void
     */
    public function test_external_book() {
        $book_name = 'A Game of Thrones';
        $url = "/api/external-books?name=" . $book_name;
        $response = $this->getJson($url);
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) =>
            $json->where('status_code', 200)
                ->where('status', 'success')
                ->has('data.0', fn($json) =>
                    $json->where('isbn', '978-0553103540')
                        ->where('name', $book_name)
                        ->where('publisher', 'Bantam Books')
                        ->etc()
                )
                ->etc()
        );

    }

    public function test_book_create() {
        $response = $this->postJson($this->book_url, $this->book_data);
        $response->assertStatus(201);
        $response->assertJson(fn(AssertableJson $json) =>
            $json->where('status_code', 201)
                ->where('status', 'success')
                ->has('data.book', fn($json) =>
                    $json->where('isbn', $this->book_data['isbn'])
                        ->where('name', $this->book_data['name'])
                        ->where('publisher', $this->book_data['publisher'])
                        ->etc()
                )
                ->etc()
        );
    }

    public function test_get_all_books() {
        $this->test_book_create();
        $response = $this->getJson($this->book_url);
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) =>
            $json->where('status_code', 200)
                ->where('status', 'success')
                ->has('data.0', fn($json) =>
                    $json->where('id', 2)
                        ->where('isbn', $this->book_data['isbn'])
                        ->where('name', $this->book_data['name'])
                        ->where('publisher', $this->book_data['publisher'])
                        ->etc()
                )
                ->etc()
        );
    }
    public function test_show_a_book() {
        $this->test_book_create();
        $response = $this->getJson($this->book_url . "/3");
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) =>
            $json->where('status_code', 200)
                ->where('status', 'success')
                ->has('data', fn($json) =>
                    $json->where('id', 3)
                        ->where('isbn', $this->book_data['isbn'])
                        ->where('name', $this->book_data['name'])
                        ->where('publisher', $this->book_data['publisher'])
                        ->etc()
                )
                ->etc()
        );
    }
    public function test_delete_a_book() {
        $this->test_book_create();
        $response = $this->deleteJson($this->book_url . "/4");
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) =>
            $json->where('status_code', 204)
                ->where('status', 'success')
                ->where('message', 'The book ' . $this->book_data['name'] . ' was deleted successfully')
                ->has('data')
                ->etc()
        );
    }
}
