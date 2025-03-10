<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Http\Middleware\AuthMiddleware;

class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     parent::__construct(); // Call the parent constructor
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $user = Auth::user(); // Get the logged-in user
        dd(Auth::user());

        switch ($user->role) {
            // case 'admin':
            //     return view('dashboard.admin');
            case 'landlord':
                return redirect()->route('dashboard.landlord');
            case 'renter':
                return redirect()->route('dashboard.renter');
            default:
                return abort(403, 'Unauthorized Access'); // Handle unexpected roles
        }
    }
}
