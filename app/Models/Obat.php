<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
        'satuan',
        'stok',
        'harga_beli',
        'harga_jual',
        'expired_date',
    ];

    protected $casts = [
        'stok' => 'integer',
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'expired_date' => 'date',
    ];

    /**
     * Get the transaksis for the obat.
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}


