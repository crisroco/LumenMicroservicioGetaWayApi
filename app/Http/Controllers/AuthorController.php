<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\AuthorService;

class AuthorController extends Controller
{

    use ApiResponser;

    /**
     * Servicio que consume el servicio de author
     * @var AuthorService
     */
    public $authorService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Return author list
     * @return Illuminate\Http\Response
     */
    public function index(){
        return $this->successResponse($this->authorService->obtainAuthors());
    }

    /**
     * Return an instance of Author
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){
        return $this->successResponse($this->authorService->createAuthors($request->all()), Response::HTTP_CREATED);
    }

    /**
     * Return an specific Author
     * @return Illuminate\Http\Response
     */
    public function show($author){
        return $this->successResponse($this->authorService->obtainAuthor($author));
    }

    /**
     * Update the information of an existing Author
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $author){
        return $this->successResponse($this->authorService->editAuthors($request->all(), $author));
    }

    /**
     * Destroy an existing Author
     * @return Illuminate\Http\Response
     */
    public function destroy($author){
        return $this->successResponse($this->authorService->deleteAuthor($author));
    }
}
