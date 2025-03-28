<?php

namespace App\Http\Controllers;

use App\Models\competence;
use App\Http\Requests\StorecompetenceRequest;
use App\Http\Requests\UpdatecompetenceRequest;
use Illuminate\Http\Request;

class CompetenceController extends Controller
{
    public function index()
    {
        $competences = Competence::all();
        return response()->json([
            'success' => true,
            'data' => $competences
        ], 200);
    }
    public function create()
    {
        return response()->json([
            'message' => 'This endpoint is not applicable for API use'
        ], 404);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|array',
            'name.*' => 'required|string|unique:competences,name',
        ]);
        
        try {
            $addedCompetences = [];
            $user = Request()->user();
            
            foreach ($request->name as $competenceName) {
            $competence = Competence::where('name', $competenceName)->first();
            
            if (!$competence) {
                $competence = Competence::create([
                'name' => $competenceName,
                ]);
            }
            

            $user->competences()->sync($competence->id);
            
            
            $addedCompetences[] = $competence;
            }

            return response()->json([
            'success' => true,
            'message' => 'Competences assigned successfully',
            'data' => $addedCompetences
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
            'success' => false,
            'message' => 'Failed to assign competences',
            'error' => $e->getMessage()
            ], 500);
        }
    }
    public function show(competence $competence)
    {
        return response()->json([
            'success' => true,
            'data' => $competence
        ], 200);
    }
    public function edit(competence $competence)
    {
        return response()->json([
            'message' => 'This endpoint is not applicable for API use'
        ], 404);
    }
    public function update(Request $request, competence $competence)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $competence->update([
                'name' => $request->name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Competence updated successfully',
                'data' => $competence
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update competence',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function destroy(competence $competence)
    {
        try {
            $competence->delete();

            return response()->json([
                'success' => true,
                'message' => 'Competence deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete competence',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
