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

    /**
     * this part developed by using scout that available for mysql in laravel 9 and configured for search in full text mod.
     * @param $q - query
     * @return \Laravel\Scout\Builder
     */
    public function search_book($q){
        return $this->search($q)
            ->query(fn ($query) => $query->with('authors'))
                 ->get()->toArray();
    }
}
