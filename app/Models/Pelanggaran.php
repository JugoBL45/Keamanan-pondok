<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggarans';
    protected $primaryKey = 'id_pelanggaran';
    protected $guarded = [];

    // Define relationships
    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }

    public function masterPelanggaran()
    {
        return $this->belongsTo(MasterPelanggaran::class, 'id_mp');
    }
}
