<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterLevel extends Model
{
    use HasFactory;

    protected $table = 'master_levels';
    protected $fillable = ['level', 'denda', 'hukuman'];
}
