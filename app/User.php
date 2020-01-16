<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Gif\GifSearch;
use App\Gif\GifFavorite;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function gifSearches()
    {
        return $this->hasMany(GifSearch::class);
    }

    public function gifFavorites()
    {
        return $this->hasMany(GifFavorite::class);
    }

    public function logGifSearch(string $search)
    {
        return $this->gifSearches()->create([
            'search' => $search
        ]);
    }

    public function addFavoriteGif(string $gifId)
    {
        return $this->gifFavorites()->create([
            'gif_id' => $gifId
        ]);
    }
    public function removeFavoriteGif(GifFavorite $favorite)
    {
        return $this->gifFavorites()->where('id', $favorite->id)->delete();
    }
}
