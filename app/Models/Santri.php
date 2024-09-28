<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santris';
    protected $primaryKey = 'id_santri';

    protected $fillable = [
        'nis', 'nama', 'kelas_id', 'alamat', 'walisantri', 'no_wali', 'foto'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'id_santri');
    }
}
