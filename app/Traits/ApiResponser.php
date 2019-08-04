<?php

namespace App\Traits;

use Illuminate\Http\Response;


trait ApiResponser{

	/**
	 * Build success response
	 * @param string|array $data 
	 * @param int $code 
	 * @return Illuminate\Http\JsonResponse
	 */
	public function successResponse($data, $code = Response::HTTP_OK)
	{
		return response($data, $code)->header('Content-Type','application/json');
	}


	/**
	 * Build error response
	 * @param string $message 
	 * @param int $code 
	 * @return Illuminate\Http\JsonResponse
	 */
	public function errorResponse($message, $code){
		return response()->json(['error' => $message, 'code' => $code], $code);
	}

	/**
	 * Build an error in JSON format
	 * @param string $message 
	 * @param int $code 
	 * @return Illuminate\Http\JsonResponse
	 */
	public function errorMessage($message, $code){
		return response($message, $code)->header('Content-Type','application/json');
	}

}