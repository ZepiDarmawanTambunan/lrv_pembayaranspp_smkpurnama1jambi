<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pembayaran;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BankSekolah extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayaran(): HasMany
    {
        return $this->hasMany(pembayaran::class, 'bank_sekolah_id', 'id');
    }
}
