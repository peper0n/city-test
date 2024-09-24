<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:cities',
        ]);

        $city = City::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return response()->json($city, 201);
    }

    public function destroy($slug)
    {
        $city = City::where('slug', $slug)->first();

        if (!$city) {
            return response()->json(['message' => 'City not found'], 404);
        }

        $city->delete();

        return response()->json(['message' => 'City deleted successfully'], 200);
    }
}
