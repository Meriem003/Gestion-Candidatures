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
        if (!Auth::check()) {
            return response()->json(['message' => 'Non autorisé'], 401);
        }
        $offer = Offer::create([
            'title' => $request->title,
            'description' => $request->description,
            'company' => $request->company,
            'location' => $request->location,
            'salary' => $request->salary,
            'deadline' => $request->deadline,
            'recruiter_id' => Auth::id(),
        ]);

        return response()->json($offer, 201);
    }


    public function update(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);
        if (Auth::id() !== $offer->recruiter_id) {
            return response()->json(['message' => 'Accès interdit'], 403);
        }
        $offer->update($request->all());
        return response()->json($offer);
    }


    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        if (Auth::id() !== $offer->recruiter_id) {
            return response()->json(['message' => 'Accès interdit'], 403);
        }
        $offer->delete();
        return response()->json(['message' => 'Offre supprimée']);
    }


    public function search(Request $request)
    {
        $query = Offer::query();
        if ($request->filled('company')) {
            $query->where('company', 'like', '%' . $request->company . '%');
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        return response()->json($query->get());
    }
}
