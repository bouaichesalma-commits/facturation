<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FactureRequest extends FormRequest
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
        // $etatremise = $this->input('etatremise');
        // dd($etatremise);
        return [
           'num' => ['required', Rule::unique('factures')->ignore($this->facture)],
            'date' => ['required', 'date'], 
            'articles' => ['required'], 
            'paiement' => ['required', 'integer'],
            'client' =>['required'],
           
            'montant' =>['required'],
            'montantPaiy'=>['nullable', 'numeric'],
            'numero_cheque' => ['nullable', 'string', 'max:255'],
            'reglements' => ['nullable', 'json'],

            'remise'=>['min:1',
            Rule::requiredIf(function () {
                return $this->input('etatremise') != 'off' ;
            })],
            
            // 'taux' => ['required_if:tva,=,on']
        ];
    }
}
