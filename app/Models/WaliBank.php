<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WaliBank extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $append = ['nama_bank_full'];

    protected function namaBankFull(): Attribute
    {
        //Bank BRI - An. Wali (23123)
        return Attribute::make(
            get: fn ($value) => $this->nama_bank.' - '.$this->nama_rekening.' ( '.$this->nomor_rekening.' )',
        );
    }
}
