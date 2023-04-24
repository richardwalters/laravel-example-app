<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('search/form');
    }

    public function results(Request $request)
    {
        return view('search/results', ['query' => $request->get('q')]);
    }
}
