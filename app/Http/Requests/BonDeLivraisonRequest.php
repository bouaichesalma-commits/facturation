<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BonDeLivraisonRequest extends FormRequest
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
            'num' => ['required', Rule::unique('bon_de_livraisons')->ignore($this->BonDeLivraison)],
            'date' => ['required', 'date'], 
            'articles' => ['required'], 
            'client' =>['required'],
            'etat' => ['required', 'integer'],
            'montant' => ['required'],
 
            // 'type' => ['required_if:delai,!=,null|nullable'],
            'taux' => ['required_if:tva,=,on'],
            'remise'=>['min:1',
            Rule::requiredIf(function () {
                return $this->input('etatremise') != 'off' ;
            })],
        ];
    }
}
