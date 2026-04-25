<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecuDePaiementRequest extends FormRequest
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
            'num' => ['required', Rule::unique('recu_de_paiements')->ignore($this->RecuDePaiement)],
            'date' => ['required', 'date'], 
            'articles' => ['required'], 
            'client' =>['required'],
            'etat' => ['required', 'integer'],
            'montant' => ['required'],
            'objectif' => ['required ','max:200'],
            'delai' => ['required'],
            // 'type' => ['required_if:delai,!=,null|nullable'],
            'taux' => ['required_if:tva,=,on'],
            'remise'=>['min:1',
            Rule::requiredIf(function () {
                return $this->input('etatremise') != 'off' ;
            })],
        ];
    }
}
