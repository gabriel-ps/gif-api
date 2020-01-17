<?php

namespace App\Http\Controllers;

use Giphy;

class GifFavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currUser = auth()->user();

        $favoriteIds = $currUser->gifFavorites()
            ->orderBy('id', 'desc')
            ->get()
            ->pluck('gif_id')
            ->toArray();

        if (empty($favoriteIds)) {
            return response()->json([
                'data' => [],
            ]);
        }

        $gifs = Giphy::getByIDs($favoriteIds);

        $this->syncFavorites($gifs);

        return response()->json($gifs);
    }

    protected function syncFavorites($gifs)
    {
        $gifs->data = collect($gifs->data);

        $gifs->data->each(function($gif) {
            $gif->favorite = true;
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $request = request();

        $this->validate($request, [
            'gif_id' => 'required'
        ]);

        auth()->user()->addFavoriteGif($request->input('gif_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $gifId
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $gifId)
    {
        $currUser = auth()->user();

        $favorite = $currUser
            ->gifFavorites()
            ->where('gif_id', $gifId)
            ->firstOrFail();

        $currUser->removeFavoriteGif($favorite);
    }
}
