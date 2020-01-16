<?php

namespace App\Http\Controllers;

use App\Gif\GifSearch;
use Illuminate\Http\Request;

class GifSearchesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // In a real project, this, of course, would have to be paginated.
        return auth()->user()
            ->gifSearches()
            ->orderBy('id', 'desc')
            ->get();
    }
}
