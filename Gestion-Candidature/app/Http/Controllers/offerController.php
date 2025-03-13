<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index()
    {
        return Offer::with('users')->get();
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string',
            'location' => 'required|string',
            'salary' => 'nullable|numeric',
            'deadline' => 'nullable|date',
        ]);

        $offer = Offer::create($request->all());

        return response()->json($offer, 201);
    }
    public function update(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);
        $offer->update($request->all());

        return response()->json($offer);
    }
    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->delete();

        return response()->json(['message' => 'Offre supprimée']);
    }

    public function search(Request $request)
    {
        $offers = Offer::where([
            ['company', 'like', '%' . $request->company . '%'],
            ['location', 'like', '%' . $request->location . '%']
        ])->get();

        return response()->json($offers);
    }

}
