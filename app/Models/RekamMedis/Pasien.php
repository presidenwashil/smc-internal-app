<?php

namespace App\Models\RekamMedis;

use App\Models\Perusahaan;
use App\Support\Traits\Eloquent\Searchable;
use App\Support\Traits\Eloquent\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pasien extends Model
{
    use Searchable, Sortable;

    protected $connection = 'mysql_sik';
    
    protected $primaryKey = 'no_rkm_medis';

    protected $keyType = 'string';

    protected $table = 'pasien';

    public $incrementing = false;

    public $timestamps = false;

    protected $searchColumns = [
        'no_rkm_medis',
        'nm_pasien',
        'no_ktp',
        'jk',
        'tmp_lahir',
        'nm_ibu',
        'alamat',
        'gol_darah',
        'pekerjaan',
        'stts_nikah',
        'agama',
        'no_tlp',
        'pnd',
        'keluarga',
        'namakeluarga',
        'kd_pj',
        'no_peserta',
        'kd_kel',
        'kd_kec',
        'kd_kab',
        'pekerjaanpj',
        'alamatpj',
        'kelurahanpj',
        'kecamatanpj',
        'kabupatenpj',
        'perusahaan_pasien',
        'suku_bangsa',
        'bahasa_pasien',
        'cacat_fisik',
        'email',
        'nip',
        'kd_prop',
        'propinsipj',
    ];

    public function suku(): BelongsTo
    {
        return $this->belongsTo(Suku::class, 'suku_bangsa', 'id');
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'kd_kel', 'kd_kel');
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kd_kec', 'kd_kec');
    }

    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'kd_kab', 'kd_kab');
    }

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'kd_prop', 'kd_prop');
    }

    public function user(): HasOne
    {
        return $this->hasOne(PasienUser::class, 'no_rkm_medis', 'no_rkm_medis');
    }

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class, 'kode_perusahaan', 'perusahaan_pasien');
    }
}
