<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use DB;

class Tagihan extends Model
{
    use SearchableTrait;
    use HasFactory;
    use LogsActivity;
    use HasFormatRupiah;
    protected $guarded = [];
    protected $dates = ['tanggal_tagihan', 'tanggal_jatuh_tempo', 'tanggal_lunas'];
    // protected $with = ['user', 'siswa', 'tagihanDetails'];
    protected $with = ['user'];
    // dilaravel 9 append atau nama atribute boleh dihapus saja
    protected $append = ['total_tagihan', 'total_pembayaran', 'status_style'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logUnguarded()->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

    public function getStatusStyleAttribute()
    {
        if ($this->status == 'lunas') {
            return 'primary';
        }
        if ($this->status == 'angsur') {
            return 'warning';
        }
        if ($this->status == 'baru') {
            return 'danger';
        }
    }

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function totalPembayaran(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->pembayaran()->sum('jumlah_dibayar'),
        );
    }

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function totalTagihan(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->tagihanDetails()->sum('jumlah_biaya'),
        );
    }

    /**
     * Get the user that owns the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusTagihanWali()
    {
        if ($this->status == 'baru') {
            return 'Belum dibayar';
        } else if ($this->status == 'lunas') {
            return 'Sudah dibayar';
        }

        return $this->status;
    }

    public function scopeWaliSiswa($q)
    {
        return $q->whereIn('siswa_id', Auth::user()->getAllSiswaId());
    }

    /**
     * Get the user that owns the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class)->withDefault();
    }

    /**
     * Get the user that owns the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function biaya(): BelongsTo
    {
        return $this->belongsTo(Biaya::class);
    }

    /**
     * Get all of the comments for the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagihanDetails(): HasMany
    {
        return $this->hasMany(TagihanDetail::class);
    }

    /**
     * Get all of the comments for the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($tagihan) {
            $tagihan->user_id = auth()->user()->id;
        });
        static::updating(function ($tagihan) {
            $tagihan->user_id = auth()->user()->id;
        });
        static::deleting(function ($tagihan) {
            // delete notif dari wali terkait tagihan (klo operator gak ada)
            DB::table('notifications')->where('data->tagihan_id', $tagihan->id)->delete();

            // delete pembayarans
            if ($tagihan->pembayaran->count() >= 1) {
                $tagihan->pembayaran()->each(function ($item) {
                    $item->delete();
                });
            }

            // delete tagihan details
            $tagihan->tagihanDetails()->delete();
        });
    }

    public function updateStatus()
    {
        $data = [];

        if ($this->total_pembayaran >= $this->total_tagihan) {
            $tanggalBayar = $this->pembayaran()
                ->orderBy('tanggal_bayar', 'desc')
                ->first()
                ->tanggal_bayar;
            $this->update([
                'status' => 'lunas',
                'tanggal_lunas' => $tanggalBayar,
            ]);
            $data['status1'] = 'lunas';
        }

        if ($this->total_pembayaran > 0 && $this->total_pembayaran < $this->total_tagihan) {
            $this->update(['status' => 'angsur', 'tanggal_lunas' => null]);
            $data['status2'] = 'angsur';
        }

        if ($this->total_pembayaran <= 0) {
            $this->update([
                'status' => 'baru',
                'tanggal_lunas' => null,
            ]);
            $data['status3'] = 'baru';
        }
    }

    protected $searchable = [
        'columns' => [
            'siswas.nama' => 10,
            'siswas.nisn' => 9,
        ],
        'joins' => [
            'siswas' => ['siswas.id', 'tagihans.siswa_id'],
        ],
    ];
}
