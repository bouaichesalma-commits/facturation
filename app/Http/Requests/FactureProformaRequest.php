<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FactureProformaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'num' => ['required', Rule::unique('facture_proformas')->ignore($this->factureProforma)],
            'date' => ['required', 'date'], 
            'articles' => ['required'], 
            'paiement' => ['required', 'integer'],
            'client' =>['required'],
            'montant' =>['required'],
            'montantPaiy'=>['required_if:typeMpaiy,=,on'],
            
            'remise'=>['min:1',
            Rule::requiredIf(function () {
                return $this->input('etatremise') != 'off' ;
            })],

           
        ];
    }
}
