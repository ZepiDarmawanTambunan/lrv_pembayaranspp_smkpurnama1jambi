<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements ToModel, WithStartRow, WithValidation
{
    public function model(array $row)
    {

        if(!array_filter($row)){
            return null;
        }

        return new Siswa([
            'nisn' => $row[1],
            'nama' => $row[2],
            'kelas' => $row[3],
            'angkatan' => $row[4],
            'jurusan' => $row[5],
            'biaya_id' => $row[6],
        ]);

    }

    public function startRow() : int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '1' => 'required|unique:siswas,nisn',
            '2' => 'required',
            '3' => 'required|in:10,11,12',
            '4' => 'required',
            '5' => 'required|in:AK',
            '6' => 'required|exists:biayas,id',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '1.required' => 'data:attribute wajib disi.',
            '2.required' => 'data:attribute wajib disi.',
            '3.required' => 'data:attribute wajib disi.',
            '4.required' => 'data:attribute wajib disi.',
            '5.required' => 'data:attribute wajib disi.',
            '6.required' => 'data:attribute wajib disi.',

            '3.in' => 'data:attribute data harus 10,11,12.',
            '5.in' => 'data:attribute data harus AK.',
            '1.unique' => 'data:attribute wajib unik.',
            '6.exists' => 'data:attribute biaya id tidak ditemukan.',
        ];
    }
}
