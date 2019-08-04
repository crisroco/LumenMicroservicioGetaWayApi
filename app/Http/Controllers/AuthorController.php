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
        $author = Author::findOrFail($author);
        return $this->successResponse($author);
    }

    /**
     * Update the information of an existing Author
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $author){
        $rules =  [
            'name' => 'max:255',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255',
        ];

        $this->validate($request, $rules);

        // se verifica si el autor existe antes de hacer el update
        $author = Author::findOrFail($author);

        $author->fill($request->all());

        //verifica si cambio algo en los datos del autor
        if ($author->isClean()) {
            return $this->errorResponse('Al menos un valor debe ser cambiado', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $author->save();

        return $this->successResponse($author);


    }

    /**
     * Destroy an existing Author
     * @return Illuminate\Http\Response
     */
    public function destroy($author){

        // se verifica si el autor existe antes de hacer el delete
        $author = Author::findOrFail($author);

        $author->delete();

        return $this->successResponse($author);

    }
}
