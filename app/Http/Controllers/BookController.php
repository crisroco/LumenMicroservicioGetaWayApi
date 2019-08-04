<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\BookService;

class BookController extends Controller
{
    use ApiResponser;

    /**
     * Servicio que consume el servicio de book
     * @var BookService
     */
    public $bookService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }


    /**
     * Return books list
     * @return Illuminate\Http\Response
     */
    public function index(){
        
        $books = Book::all();
        return $this->successResponse($books);
    }

    /**
     * Return an instance of Book
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){
        $rules =  [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1',
        ];

        $this->validate($request, $rules);

        $book = Book::create($request->all());

        return $this->successResponse($book, Response::HTTP_CREATED);

    }

    /**
     * Return an specific Book
     * @return Illuminate\Http\Response
     */
    public function show($book){
        $book = Book::findOrFail($book);
        return $this->successResponse($book);
    }

    /**
     * Update the information of an existing Book
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $book){
        
        $rules =  [
            'title' => 'max:255',
            'description' => 'max:255',
            'price' => 'min:1',
            'author_id' => 'min:1',
        ];

        $this->validate($request, $rules);

        // se verifica si el libro existe antes de hacer el update
        $book = Book::findOrFail($book);

        $book->fill($request->all());

        //verifica si cambio algo en los datos del libro
        if ($book->isClean()) {
            return $this->errorResponse('Al menos un valor debe ser cambiado', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $book->save();

        return $this->successResponse($book);


    }

    /**
     * Destroy an existing Book
     * @return Illuminate\Http\Response
     */
    public function destroy($book){        

        // se verifica si el libro existe antes de hacer el delete
        $book = Book::findOrFail($book);

        $book->delete();

        return $this->successResponse($book);

    }
}
