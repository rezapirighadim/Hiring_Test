<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Book extends Model
{
    use HasFactory , Searchable;
    protected $guarded = [];
    public function authors(){
        return $this->belongsToMany(Author::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */

    #[SearchUsingFullText(['title'])]
    #[SearchUsingFullText(['summary'])]
    public function toSearchableArray()
    {

        return [
            'title' => $this->title,
            'publisher' => $this->publisher,
            'summary' => $this->summary,
        ];
    }
}
