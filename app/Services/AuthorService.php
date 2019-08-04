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

	public function __construct()
	{
		//llamamos a la url que se configura en el archivo services.php
		$this->baseUri = config('services.authors.base_uri');
	}


	/**
	 * Obtener la lista completa de autores desde author service
	 * @return string
	 */
	public function obtainAuthors(){
		return $this->performRequest('GET', '/authors');
	}
}