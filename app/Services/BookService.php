<?php
namespace App\Services;

use App\Traits\ConsumesExternalServices;

class BookService
{
	use ConsumesExternalServices;

	/**
	 * URL base para consumir el servicio de libros
	 * @var string
	 */
	public $baseUri;

	public function __construct()
	{
		//llamamos a la url que se configura en el archivo services.php
		$this->baseUri = config('services.books.base_uri');
	}

	/**
	 * Obtener la lista completa de libros desde book service
	 * @return string
	 */
	public function obtainBooks(){
		return $this->performRequest('GET', '/books');
	}


	/**
	 * Crear un libro enviado la solicitud al microservicio Book
	 * @return string
	 */
	public function createBooks( $data){
		return $this->performRequest('POST', '/books', $data);
	}

	/**
	 * Obtener un libro por el id
	 * @return string
	 */
	public function obtainBook($book){
		return $this->performRequest('GET', "/books/{$book}");
	}

	/**
	 * Editar un libro por el id
	 * @return string
	 */
	public function editBooks($data, $book){
		return $this->performRequest('PUT', "/books/{$book}", $data);
	}

	/**
	 * Eliminar un libro por el id
	 * @return string
	 */
	public function deleteBook($book){
		return $this->performRequest("DELETE", "/books/{$book}");
	}
}