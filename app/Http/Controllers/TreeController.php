<?php

namespace App\Http\Controllers;

use App\Models\Tree;
use Illuminate\Http\Request;

class TreeController extends Controller
{
    public function showMap()
    {
        $trees = Tree::all();
        return view('filament.pages.map', compact('trees'));
    }
}
