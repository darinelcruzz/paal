<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EgressRequest extends FormRequest
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
        return [
            'provider_id' => 'sometimes|required',
            'folio' => 'sometimes|required',
            'pdf_bill' => 'required',
            'expiration' => 'required',
            'amount' => 'required',
            'iva' => 'sometimes|required|lt:amount',
            'emission' => 'required',
            'pdf_complement' => 'sometimes|required',
            'complement_amount' => 'sometimes|required|lt:amount',
            'complement_date' => 'sometimes|required',
            'returned_to' => 'sometimes|required',
            'provider_name' => 'sometimes|required',
        ];
    }

    public function messages()
    {
        return [
            'iva.lt' => 'No puede ser mayor que total',
            'complement_amount.lt' => 'No puede ser mayor que el total',
            'provider_id.required' => 'El campo prroveedor es obligatorio.'
        ];
    }
            
}
