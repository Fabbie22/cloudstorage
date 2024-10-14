<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    use HasFactory;

    protected $fillable = ['path', 'user_id'];


    public function users()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function shares()
    {
        return $this->hasMany(Share::class, 'file_id');
    }
}
