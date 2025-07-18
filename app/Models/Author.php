<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'birth_date'];
    protected $casts = [ 'birth_date' => 'date:Y-m-d' ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
