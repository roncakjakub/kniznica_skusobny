<?php

namespace App\Http\Controllers;

use App\Book;
use App\Genre;
use App\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make(
            $data, [
            'search_word' => 'nullable|max:255'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors());
        } else {
            $books = Book::with('resource','genre');
            if (!empty($data["search_word"])) {
                $books = $books->where("books.name","LIKE","%".$data["search_word"]."%");
            }
            $books = $books->orderBy('name')->get();


            $data['books'] = $books;
            $data['genres'] = Genre::all();
            $ret["status"] = 200;
        }
        return view('books',$data);
    }

    /**
     * Show the form for creating the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['genres'] = Genre::all();
        return view('add_book',$data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make(
            $data, [
            'name' => 'nullable|max:255',
            'genre_id' => 'required_without:genre|exists:genres,id',
            'genre' => 'required_without:genre_id|max:255',
            'isbn' => 'string|max:40',
            'abstract' => 'max:255',
            'email' => 'email|max:255',
            'pages' => 'integer|min:1',
            'image' => 'nullable|image',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors());
        } else {
            $book = new Book;
            $book->name = $data['name'];
            $book->isbn = $data['isbn'];
            $book->abstract = $data['abstract'];
            $book->email = $data['email'];
            $book->pages = $data['pages'];
            if (!empty($data['genre_id'])) {
                $book->genre_id = $data['genre_id'];
            } else {
                $book->genre_id = Genre::firstOrCreate(['name' => $data['genre']])->id;
            }

            if (!$book->save()) {
                abort(500);
            }

            if (!empty($data['image'])) {
                $rc = new ResourceController();
                $res = new Resource();

                $imgRequest = new \Illuminate\Http\Request();
                $imgRequest->merge(["image" => $data["image"]]);
                $resRet = $rc->StoreImage($imgRequest, 300);
                if($resRet->getStatusCode() != 200){
                    $this->destroy($book);
                    abort(500);
                }
                $res->url = $resRet->getData()->url;
                $res->alt = 'Obal knihy';
                if (!$book->resource()->save($res)) {
                    $this->destroy($book);
                    abort(500);
                }
            }
            return redirect()->route('index')->with('success', "Operácia bola úspešná");

        }
    }

    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Book $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Book $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Book $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {

        if ($book->resource) {
            $rc = new ResourceController();
            $rc->destroy($book->resource);
        }
        if (!$book->delete()) {
            abort(500);
        }
        return redirect()->route('index')->with('success', "Operácia bola úspešná");
    }
}
