<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Property;
use App\Models\User;

class LandlordController extends Controller
{
//     public function index()
// {
//     $user = auth()->user();
//     // جلب العقارات التي يملكها المستخدم الحالي بصفته مالك
//     $properties = $user->scopeLandlords()->wherePivot('role', 'landlord')->get();
//     dd($properties);

//     return view('dashboard.landlord', compact('properties'));
// }
public function index()
{
    $user = auth()->user();
    $properties = $user->ownedProperties()->get();
    // dd($properties);

    return view('dashboard.landlord', compact('properties'));
}

public function getTenants()
{
    $landlord = auth()->user();

    $renters = User::whereHas('tenantContracts', function ($query) use ($landlord) {
        $query->whereHas('property', function ($q) use ($landlord) {
            $q->where('landlord_id', $landlord->id);
        });
    })->get();

    return view('dashboard.landlord', compact('renters'));
}


}
