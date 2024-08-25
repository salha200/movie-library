<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    /**
     * 
     * @var array
     */
    protected $fillable = ['title', 'director', 'genre', 'release_year', 'description'];
    //relation with table rating
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}
