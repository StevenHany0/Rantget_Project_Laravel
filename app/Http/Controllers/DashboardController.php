<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'landlord':
                return redirect()->route('landlord.dashboard');
            case 'renter':
                return redirect()->route('renter.dashboard');
            default:
                return abort(403, 'Ahmed Elhussini - Unauthorized Role');
        }
    }
}
