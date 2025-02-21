<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'author_id',
    ];
    public function author() {
        return $this->belongsTo(Author::class);
    }
    public function genres() {
        return $this->belongsToMany(Genre::class, 'book_genres');
    }
    
}