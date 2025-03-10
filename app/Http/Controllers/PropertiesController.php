<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Property;
use App\Models\User;

class PropertiesController extends Controller
{
    public function index()
    {
        $properties = Property::paginate(100);
        return view("properties.index", compact("properties"));
    }

    public function create()
    {
        return view("properties.create");
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً!');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:unavailable,reserved,available,rent',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('properties_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // إنشاء العقار
        $property = Property::create($validatedData);

        // تعيين المالك للعقار
        $property->users()->attach(Auth::id(), ['role' => 'landlord']);

        return redirect()->route('properties.index')->with('success', 'تمت إضافة العقار بنجاح!');
    }


    // public function show($property)
    // {
    //     $property = Property::findOrFail($property); // Fetch the property by ID (or slug)
    //     return view('properties.show', compact('property'));
    // }
    public function show(Property $property)
{
    return view('properties.show', compact('property'));
}



    public function edit(Property $property)
    {
        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:unavailable,reserved,available,rent',
        ]);

        if ($request->hasFile('image')) {
            if ($property->image) {
                Storage::disk('public')->delete($property->image);
            }

            $imagePath = $request->file('image')->store('properties_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $property->update($validatedData);

        return redirect()->route('properties.show', $property->id);
    }

    public function destroy(Property $property)
    {
        if ($property->image) {
            Storage::disk('public')->delete($property->image);
        }

        $property->delete();

        return redirect()->route('properties.index')->with('success', 'تم حذف العقار بنجاح.');
    }
}
