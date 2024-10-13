<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{

    use HasFactory;

    protected $fillable = ['file_id', 'owner_email', 'recipient_email'];
}
