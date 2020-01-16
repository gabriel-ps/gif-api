<?php

namespace App\Http\Controllers;

use Giphy;
use Illuminate\Http\Request;
use App\Gif\GifFavorite;

class GifsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();

        $this->validate($request, [
            'search' => 'required'
        ]);

        $search = $request->input('search');
        $currUser = auth()->user();

        $currUser->logGifSearch($search);

        $gifs = Giphy::search($search);

        $this->syncFavorites($currUser, $gifs);

        return response()->json($gifs);
    }

    protected function syncFavorites($user, $gifs)
    {
        $gifs->data = collect($gifs->data);

        $favorites = $user
            ->gifFavorites()
            ->whereIn('gif_id', $gifs->data->pluck('id'))
            ->get();

        $gifs->data->each(function($gif) use ($favorites) {
            $gif->favorite = !!$favorites->firstWhere('gif_id', $gif->id);
        });
    }

    public function favorite()
    {
        $request = request();

        $this->validate($request, [
            'gif_id' => 'required'
        ]);

        auth()->user()->addFavoriteGif($request->input('gif_id'));
    }

    public function unfavorite($gifId)
    {
        $currUser = auth()->user();

        $favorite = $currUser
            ->gifFavorites()
            ->where('gif_id', $gifId)
            ->firstOrFail();

        $currUser->removeFavoriteGif($favorite);
    }
}
