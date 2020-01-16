<?php

namespace App\Gif;

use Illuminate\Database\Eloquent\Model;

class GifFavorite extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['gif_id'];
}
