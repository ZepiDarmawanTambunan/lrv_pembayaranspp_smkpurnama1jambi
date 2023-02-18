<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBankSekolahRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'bank_id' => 'required',
            'nama_rekening' => 'required',
            'nomor_rekening' => 'required|unique:bank_sekolahs,nomor_rekening',
        ];
    }
}
