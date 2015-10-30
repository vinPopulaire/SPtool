<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class SignalsRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return ['username'=>'required',
				'device_id'=>'required',
				'video_id'=>'required',
				'action'=>'required|integer'

		];
	}
	public function response(array $errors)
	{

//		return  Response::make('Permission denied foo!', 403);
//		tried but didn't work
//		 return Response::json(array(
//				 array(
//				 'message' => 'Validation Failed',
//				 'errors' => $errors),
//			 		'404'
//			 )
//
//		 );
		$e =  array(
			'error' => 'Validation Failed',
			'errors' => $errors);
		return response($e, 400)->header('Content-Type', 'application/json');

	}
}
