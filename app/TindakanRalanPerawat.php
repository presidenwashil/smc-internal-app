<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TindakanRalanPerawat extends Pivot
{
    protected $table = 'rawat_jl_drpr';

    public $incrementing = false;

    public $timestamps = false;

    public static $pivotColumns = [
        'nip',
        'tgl_perawatan',
        'jam_rawat',
        'material',
        'bhp',
        'tarif_tindakandr',
        'kso',
        'menejemen',
        'biaya_rawat',
        'stts_bayar',
    ];

    public function perawat()
    {
        return $this->belongsTo('App\Dokter', 'kd_dokter', 'kd_dokter');
    }
}
