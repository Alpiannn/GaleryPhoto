<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'photo_id', 'user_id'];

    public function user()
    {
        return $table->belongsTo(User::class);
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}
