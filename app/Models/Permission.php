<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


    class Permission extends Model
    {
        use HasFactory;
    
        protected $fillable = [
            'id_santri',
            'reason',
            'start_time',
            'end_time',
            'status'
        ];
    
        public function santri()
        {
            return $this->belongsTo(Santri::class, 'id_santri');
        }
    
        public function isLate()
        {
            return !$this->isReturned() && now()->greaterThan($this->end_time);
        }
    
        public function isReturned()
        {
            return $this->status == 'Tepat Waktu';
        }
    
        public function pelanggaran()
        {
            return $this->belongsTo(Pelanggaran::class, 'id_pelanggaran');
        }
        public function masterPelanggaran()
        {
            return $this->belongsTo(MasterPelanggaran::class, 'id_mp');
        }
    }
 