<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paper extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'abstract',
        'file_path',
        'author_id',
        'keywords',
        'fields'
    ];

    protected $casts = [
        'fields' => 'array', // Cast fields to array to handle JSON conversion automatically
    ];

    protected static function booted()
    {
        static::creating(function ($paper) {
            if (auth()->check() && is_null($paper->author_id)) {
                $paper->author_id = auth()->id();
            }
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function coAuthors()
    {
        return $this->belongsToMany(User::class, 'paper_user', 'paper_id', 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
