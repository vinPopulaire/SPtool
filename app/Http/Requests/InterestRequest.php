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
				'arts' => 'required|integer|min:0|max:5',
				'disasters' => 'required|integer|min:0|max:5',
				'environment' => 'required|integer|min:0|max:5',
				'education' => 'required|integer|min:0|max:5',
				'health' => 'required|integer|min:0|max:5',
				'lifestyle' => 'required|integer|min:0|max:5',
				'media' => 'required|integer|min:0|max:5',
				'holidays' => 'required|integer|min:0|max:5',
				'politics' => 'required|integer|min:0|max:5',
				'religion' => 'required|integer|min:0|max:5',
				'society' => 'required|integer|min:0|max:5',
				'transportation' => 'required|integer|min:0|max:5',
				'wars' => 'required|integer|min:0|max:5',
				'work' => 'required|integer|min:0|max:5',
				//
			];
		}

		if (Request::isMethod('put')) {
			return [

				'arts' => 'integer|min:0|max:5',
				'disasters' => 'integer|min:0|max:5',
				'environment' => 'integer|min:0|max:5',
				'education' => 'integer|min:0|max:5',
				'health' => 'integer|min:0|max:5',
				'lifestyle' => 'integer|min:0|max:5',
				'media' => 'integer|min:0|max:5',
				'holidays' => 'integer|min:0|max:5',
				'politics' => 'integer|min:0|max:5',
				'religion' => 'integer|min:0|max:5',
				'society' => 'integer|min:0|max:5',
				'transportation' => 'integer|min:0|max:5',
				'wars' => 'integer|min:0|max:5',
				'work' => 'integer|min:0|max:5',
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
