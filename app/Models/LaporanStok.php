<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanStok extends Model
{
    use HasFactory;

    protected $table = 'laporan_stok';

    protected $fillable = [
        'id_obat',
        'id_staff',
        'jumlah',
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tanggal' => 'date',
    ];

    /**
     * Get the obat alkes that owns the laporan stok.
     */
    public function obatAlkes()
    {
        return $this->belongsTo(ObatAlkes::class, 'id_obat');
    }

    /**
     * Get the staff that owns the laporan stok.
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'id_staff');
    }
}
