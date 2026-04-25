<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgenceRequest extends FormRequest
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
            'nom' => ['required', 'string'],
            'gsm' => ['required', 'string'],
            'fixe' => ['required', 'string'],
            'site' => ['required', 'string'],
            'adresse' => ['required', 'string'],
            'logo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'cachet' => ['nullable', 'file', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'signature' => ['nullable', 'file', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'email' => ['required', 'email', 'max:100'],
            'ice' => ['required', 'string'],
            'rc' => ['required', 'integer'],
            'if' => ['required', 'integer'],
            'tp' => ['required', 'integer'],
            'cnss' => ['required', 'integer'],
            'compte' => ['required', 'string'],
        ];
    }
}
