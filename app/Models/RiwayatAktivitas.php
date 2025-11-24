<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAktivitas extends Model
{
    use HasFactory;

    protected $table = 'riwayat_aktivitas';

    protected $fillable = [
        'id_staff',
        'id_obat',
        'jenis_aksi',
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    /**
     * Get the staff that owns the riwayat aktivitas.
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'id_staff');
    }

    /**
     * Get the obat alkes that owns the riwayat aktivitas.
     */
    public function obatAlkes()
    {
        return $this->belongsTo(ObatAlkes::class, 'id_obat');
    }
}
