<?php

namespace App\Http\Controllers;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Http;

class BookController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $query = $request->query();
        $output = [
            "status_code" => 200,
            "status" => "success",
            "data" => [],
        ];
        if (!$query) {
            $books = Book::all();
            $output['data'] = $books->toArray();
        } else {
            $key = array_keys($query)[0];
            try {
                $books = Book::where($key, 'LIKE', '%' . $query[$key] . '%')
                    ->get();
                if ($books) {
                    $output['data'] = $books->toArray();
                }
            } catch (QueryException $e) {
                throw $e->getMessage();
            }
        }
        return response($output);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request) {
        $book = $request->input();
        $output = [
            "status_code" => 201,
            "status" => "success",
            "data" => [],
        ];
        try {
            $create = Book::create($book);
            $output['data'] = ['book' => $book];
            return response()->json($output, $output['status_code']);
        } catch (QueryException $e) {
            $message = $e->getMessage();
            $output['status_code'] = 500;
            $output['status'] = "error";
            $output['message'] = $message;
            return response()->json($output, $output['status_code']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $output = [
            "status_code" => 400,
            "status" => "not found",
            "data" => [],
        ];
        try {
            $book = Book::find($id);
            if ($book) {
                $data = $book->toArray();
                $output['status_code'] = 200;
                $output['status'] = "success";
                $output['data'] = $data;
                return response()->json($output, $output['status_code']);
            } else {
                return (response()->json($output, $output['status_code']));
            }
        } catch (QueryException $e) {
            throw $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, $id) {
        if ($id) {
            $output = [
                "status_code" => 200,
                "status" => "success",
                "message" => "",
                "data" => [],
            ];
            $book = $request->input();
            $findBook = Book::find($id);
            if ($findBook) {
                try {
                    $update = $findBook->Update($book);
                    $output['message'] = "The book " . $book['name'] . " was updated successfully";
                    $output['data'] = ['book' => $book];
                    return response()->json($output, $output['status_code']);
                } catch (QueryException $e) {
                    throw $e->getMessage();
                }
            }
        }
        die("Invalid Book Id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $book = Book::find($id);
        $book = ($book) ? $book->toArray() : die('book not found');
        $output = [
            "status_code" => 204,
            "status" => "success",
            "message" => "",
            "data" => [],
        ];
        try {
            $delete = Book::destroy($id);
            if ($delete) {
                $output['message'] = "The book " . $book['name'] . " was deleted successfully";
                return response()->json($output);
            }
        } catch (QueryException $e) {
            throw $e->getMessage();
        }

    }
}
