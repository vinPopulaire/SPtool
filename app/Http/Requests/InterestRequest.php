<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class InterestRequest extends Request
{

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
		if (Request::isMethod('post')) {

			return [
				'username' => 'required',
				'arts' => 'integer|min:0|max:5',
				'disasters' => 'integer|min:0|max:5',
				'environment' => 'integer|min:0|max:1',
				'education' => 'integer|min:0|max:1',
				'health' => 'integer|min:0|max:1',
				'lifestyle' => 'integer|min:0|max:1',
				'media' => 'integer|min:0|max:1',
				'holidays' => 'integer|min:0|max:1',
				'politics' => 'integer|min:0|max:1',
				'religion' => 'integer|min:0|max:1',
				'society' => 'integer|min:0|max:1',
				'transportation' => 'integer|min:0|max:1',
				'wars' => 'integer|min:0|max:1',
				'work' => 'integer|min:0|max:1',
				//
			];
		}

		if (Request::isMethod('put')) {
			return [

				'arts' => 'integer|min:0|max:1',
				'disasters' => 'integer|min:0|max:1',
				'environment' => 'integer|min:0|max:1',
				'education' => 'integer|min:0|max:1',
				'health' => 'integer|min:0|max:1',
				'lifestyle' => 'integer|min:0|max:1',
				'media' => 'integer|min:0|max:1',
				'holidays' => 'integer|min:0|max:1',
				'politics' => 'integer|min:0|max:1',
				'religion' => 'integer|min:0|max:1',
				'society' => 'integer|min:0|max:1',
				'transportation' => 'integer|min:0|max:1',
				'wars' => 'integer|min:0|max:1',
				'work' => 'integer|min:0|max:1',
				//
			];

		}
	}
	public function response(array $errors)
	{


		$e =  array(
			'error' => 'Validation Failed',
			'errors' => $errors);
		return response($e, 400)->header('Content-Type', 'application/json');

	}
}
