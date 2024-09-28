<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'user_name', 'role_name', 'activity'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function log($activity)
    {
        if(auth()->check()) {
            self::create([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
                'role_name' => auth()->user()->role, // Ganti dengan kolom yang sesuai dengan model User Anda
                'activity' => $activity,
            ]);
        }
    }
}
