<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Movie extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['title', 'director', 'description'];

    protected $fillable = [
        'title',
        'director',
        'description',
        'image',
        'genre',
        'year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
