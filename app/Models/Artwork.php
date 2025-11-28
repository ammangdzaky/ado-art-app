<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'image_path',
        'tags'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function challenges()
    {
        return $this->belongsToMany(Challenge::class, 'challenge_submissions')
                    ->withPivot('rank', 'submitted_at')
                    ->withTimestamps();
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    public function collections() {
        return $this->belongsToMany(Collection::class, 'artwork_collection');
    }
}