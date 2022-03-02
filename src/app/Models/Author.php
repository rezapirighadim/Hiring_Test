<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function books(){
        return $this->belongsToMany(Book::class);
    }

//    $user->roles()->getRelatedIds();

// or add a method for this:
    public function getBookIds()
    {
        return $this->books()->getRelatedIds();
    }

//    $user->getRoleIds();
}
