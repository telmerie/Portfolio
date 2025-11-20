<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'teaser',
        'body',
        'user_id',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
