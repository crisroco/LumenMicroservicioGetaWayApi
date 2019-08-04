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
