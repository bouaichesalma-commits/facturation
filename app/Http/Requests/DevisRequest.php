<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DevisRequest extends FormRequest
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
            'num' => ['required', Rule::unique('devis')->ignore($this->devi)],
            'date' => ['required', 'date'], 
            'articles' => ['required'], 
            'client' =>['required'],
            'etat' => ['required', 'integer'],
            'montant' => ['required'],
 
           
            'taux' => ['required_if:tva,=,on'],
            'remise'=>['min:1',
            Rule::requiredIf(function () {
                return $this->input('etatremise') != 'off' ;
            })],
        ];
    }
}
