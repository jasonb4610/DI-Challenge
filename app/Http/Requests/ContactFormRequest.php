<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
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
     * Override the all() method of the FormRequest class to sanitize phone input
     * before passing to rules for validation
     * @return array
     */
    public function all() {
        $input = parent::all();

        if ($input['phone']) {
            $input['phone'] = preg_replace('/[-+\ ]/', '', $input['phone']);
        }

        return $input;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ];
    }
}
