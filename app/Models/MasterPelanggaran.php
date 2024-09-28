<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'master_pelanggarans';
    protected $primaryKey = 'id_mp';
    // protected $fillable = ['nama', 'jenis', 'level', 'denda', 'hukuman','larangan', 'max'];
    protected $guarded = [];

    // Define relationships
    public function pelanggarans()
    {
        return $this->hasMany(Pelanggaran::class, 'id_mp');
    }
}
