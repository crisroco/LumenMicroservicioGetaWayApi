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
}