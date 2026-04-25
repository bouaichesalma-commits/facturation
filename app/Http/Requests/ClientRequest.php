<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nom' => ['required'],
            'tel' => ['max:15'],
            'email' => ['nullable', 'email', 'max:100', Rule::unique('clients')->ignore($this->client)],
            'DateExpiration' => ['required_if:etatDateExp,=,on'],
        ];
    }

    

}
