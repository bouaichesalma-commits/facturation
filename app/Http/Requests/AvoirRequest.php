<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AvoirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'num' => ['required', Rule::unique('avoir')->ignore($this->avoir)],
            'date' => ['required', 'date'],
            'articles' => ['required'], 
            'client' => ['required', 'exists:clients,id'],
            'etat' => ['required', 'integer'],
            'montant' => ['required', 'numeric'],
            'taux' => ['required_if:tva,on'],
            'remise' => [
                'min:1',
                Rule::requiredIf(function () {
                    return $this->input('etatremise') != 'off';
                }),
            ],
        ];
    }
}
