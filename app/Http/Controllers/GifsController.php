<?php

namespace App\Http\Controllers;

use Giphy;
use Illuminate\Http\Request;
use App\Gif\GifSearch;

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

        auth()->user()->logGifSearch($search);

        $gifs = Giphy::search($search);

        return response()->json($gifs);
    }
}
