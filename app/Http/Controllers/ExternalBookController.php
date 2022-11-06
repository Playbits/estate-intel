<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExternalBookController extends Controller {

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request) {
        return $this->getExternalBooksByName($request);
    }

    /* This method should return json object of books from external sources  */
    protected function getExternalBooksByName(Request $request) {
        $book_api = getenv('EXTERNAL_BOOKS_URL');
        $output = [
            "status_code" => 404,
            "status" => "not found",
            "data" => [],
        ];
        $name_of_book = $request->query('name');
        $book_url = $book_api . "/books";
        $http_request = Http::get($book_url, ['name' => $name_of_book]);
        $data = $http_request->json();

        if ($data) {
            $output = [
                "status_code" => 200,
                "status" => "success",
                "data" => [$this->formatBookData($data)],
            ];
        }
        return response($output, $output['status_code']);
    }

    private function formatBookData($data = []) {
        $output = [];
        foreach ($data as $key => $value) {
            $output['name'] = $value['name'];
            $output['isbn'] = $value['isbn'];
            $output['authors'] = $value['authors'];
            $output['number_of_pages'] = $value['numberOfPages'];
            $output['publisher'] = $value['publisher'];
            $output['country'] = $value['country'];
            $output['release_date'] = date_format(date_create($value['released']), 'Y-m-d');
        }
        return $output;
    }

}
