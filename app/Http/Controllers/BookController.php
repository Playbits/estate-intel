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
    public function index() {
        $books = Book::all();
        $output = [
            "status_code" => 200,
            "status" => "success",
            "data" => $books->toArray(),
        ];
        return response($output);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request) {
        $fields = $request->input();
        $output = [
            "status_code" => 201,
            "status" => "success",
            "data" => [],
        ];
        try {
            $create = Book::create($fields);
            $output['data'] = ['book' => $fields];
            return response()->json($output, $output['status_code']);
        } catch (QueryException $e) {
            $message = $e->message;
            $output['status_code'] = 403;
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
