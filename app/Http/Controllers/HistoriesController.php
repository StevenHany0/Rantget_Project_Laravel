<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;    

class HistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $histories = History::with('contract')->latest()->get();
    return view('histories.index', compact('histories'));

    }

}
