<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'curator_id',
        'title',
        'description',
        'rules',
        'prize',
        'banner_path',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function curator()
    {
        return $this->belongsTo(User::class, 'curator_id');
    }

    public function submissions()
    {
        return $this->hasMany(ChallengeSubmission::class);
    }

    public function artworks()
    {
        return $this->belongsToMany(Artwork::class, 'challenge_submissions')
                    ->withPivot('rank', 'submitted_at')
                    ->withTimestamps();
    }
}