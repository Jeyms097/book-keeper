<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'author_id', 'published_date'];
    protected $casts = ['published_date' => 'date:Y-m-d'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
