<?php
namespace App\Services;

use App\Traits\ConsumesExternalServices;

class AuthorService
{
	use ConsumesExternalServices;

	/**
	 * URL base para consumir el servicio de autores
	 * @var string
	 */
	public $baseUri;

	/**
	 * Secret para consumir el servicio de autores
	 * @var string
	 */
	public $secret;

	public function __construct()
	{
		//llamamos a la url que se configura en el archivo services.php
		$this->baseUri = config('services.authors.base_uri');
		//llamamos al secret que se configura en el archivo services.php
		$this->secret = config('services.authors.secret');

	}


	/**
	 * Obtener la lista completa de autores desde author service
	 * @return string
	 */
	public function obtainAuthors(){
		return $this->performRequest('GET', '/authors');
	}


	/**
	 * Crear un autor enviado la solicitud al microservicio Author
	 * @return string
	 */
	public function createAuthors( $data){
		return $this->performRequest('POST', '/authors', $data);
	}

	/**
	 * Obtener un autor por el id
	 * @return string
	 */
	public function obtainAuthor($author){
		return $this->performRequest('GET', "/authors/{$author}");
	}

	/**
	 * Editar un autor por el id
	 * @return string
	 */
	public function editAuthors($data, $author){
		return $this->performRequest('PUT', "/authors/{$author}", $data);
	}

	/**
	 * Eliminar un autor por el id
	 * @return string
	 */
	public function deleteAuthor($author){
		return $this->performRequest("DELETE", "/authors/{$author}");
	}
}