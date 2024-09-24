<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $selectedCitySlug = $request->session()->get('selected_city_slug');
        $cities = City::all();
        if ($selectedCitySlug) {
            return redirect()->route('cities.show', $selectedCitySlug);
        }

        return view('cities.index', compact('cities', 'selectedCitySlug'));
    }

    public function show(Request $request, $citySlug)
    {
        $city = City::where('slug', $citySlug)->firstOrFail();
        $request->session()->put('selected_city_slug', $citySlug);

        return view('cities.show', compact('city'));
    }

    public function about(Request $request, $citySlug)
    {
        $city = City::where('slug', $citySlug)->firstOrFail();
        return view('cities.about', compact('city'));
    }

    public function news(Request $request, $citySlug)
    {
        $city = City::where('slug', $citySlug)->firstOrFail();
        return view('cities.news', compact('city'));
    }

    public function resetCity(Request $request)
    {
        $request->session()->forget('selected_city_slug');
        return redirect()->route('cities.index');
    }
}
