<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Services\BookService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    use ApiResponser;

    /**
     * Servicio que consume el servicio de book
     * @var BookService
     */
    public $bookService;

    /**
     * Consumir el servicio de author
     * @var AuthorService
     */
    public $authorService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    /**
     * Return Book list
     * @return Illuminate\Http\Response
     */
    public function index(){
        return $this->successResponse($this->bookService->obtainBooks());
    }

    /**
     * Return an instance of Book
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){

        $this->authorService->obtainAuthor($request->author_id);
        
        return $this->successResponse($this->bookService->createBooks($request->all()), Response::HTTP_CREATED);
    }

    /**
     * Return an specific Book
     * @return Illuminate\Http\Response
     */
    public function show($book){
        return $this->successResponse($this->bookService->obtainBook($book));
    }

    /**
     * Update the information of an existing Book
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $book){
        return $this->successResponse($this->bookService->editBooks($request->all(), $book));
    }

    /**
     * Destroy an existing Book
     * @return Illuminate\Http\Response
     */
    public function destroy($book){
        return $this->successResponse($this->bookService->deleteBook($book));
    }
}
