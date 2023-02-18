<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
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
                'wali_id' => 'nullable|exists:users,id',
                'nama' => 'required|min:3|max:255',
                'biaya_id' => 'required|exists:biayas,id',
                'nisn' => 'required|unique:siswas',
                'jurusan' => 'required',
                'kelas' => 'required',
                'angkatan' => 'required',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5048',
        ];
    }
}
