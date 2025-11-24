<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatAlkes extends Model
{
    use HasFactory;

    protected $table = 'obat_alkes';

    protected $fillable = [
        'nama',
        'kategori',
        'stok',
        'kadaluarsa',
        'supplier',
        'satuan',
        'lokasi',
        'keterangan',
    ];

    protected $casts = [
        'stok' => 'integer',
        'kadaluarsa' => 'date',
    ];

    /**
     * Get the laporan stok for the obat alkes.
     */
    public function laporanStok()
    {
        return $this->hasMany(LaporanStok::class, 'id_obat');
    }

    /**
     * Get the riwayat aktivitas for the obat alkes.
     */
    public function riwayatAktivitas()
    {
        return $this->hasMany(RiwayatAktivitas::class, 'id_obat');
    }
}
