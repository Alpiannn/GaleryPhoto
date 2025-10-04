<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function album()
    {
        return $this->belongsTo(Album::class);
    }
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
    public function like()
    {
        return $this->hasMany(Like::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['arsip'] ?? false, function ($query, $arsip) {
            return $query->where('publish', false);
        });
        $query->when($filters['cari'] ?? false, function ($query, $cari) {
            return $query->where('nama', 'like', '%' . $cari . '%');
        });
        $query->when($filters['album'] ?? false, function ($query, $album) {
            return $query->whereHas('album', function ($query) use ($album) {
                $query->where('nama', $album);
            });
        });
    }
}
