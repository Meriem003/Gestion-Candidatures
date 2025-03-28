<?php

namespace App\Http\Controllers;

use App\Models\offer;
use App\Http\Requests\StoreofferRequest;
use App\Http\Requests\UpdateofferRequest;
use App\Models\Offer as ModelsOffer;
use Illuminate\Http\Request;
class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::all();
        return response()->json($offers);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'employment_type' => 'required|in:Full-time,Part-time,Contract,Freelance,Internship',
            'experience_level' => 'nullable|in:Entry-level,Mid-level,Senior,Manager,Executive',
            'required_skills' => 'nullable|json',
            'deadline' => 'nullable|date',
            'is_active' => 'boolean',
            'image' => 'nullable|string|max:255',
            ]);

        try {
            $user = $request->user();

            $validated['user_id'] = $user->id;

            $offer = Offer::create($validated);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json([
            'offer' => $offer,
        ], 201);
    }
    public function show(offer $offer)
    {
        return response()->json($offer);
    }
    public function update(Request  $request, offer $offer)
    {
        $validated =  $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'employment_type' => 'required|in:Full-time,Part-time,Contract,Freelance,Internship',
            'experience_level' => 'nullable|in:Entry-level,Mid-level,Senior,Manager,Executive',
            'required_skills' => 'nullable|json',
            'deadline' => 'nullable|date',
            'is_active' => 'boolean',
            'image' => 'nullable|string|max:255',
        ]);

        $offer->update($validated);

        return response()->json([
           'offer' => "offer",
        ],201);
    }
    public function destroy(offer $offer)
    {
        $this->authorize('delete', $offer); 

        $offer->delete();

        return response()->json(['message' => 'Offer deleted successfully'], 200);
    }
}
