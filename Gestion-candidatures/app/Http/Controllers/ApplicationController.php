<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::all();
        if ($applications->isEmpty()) {
            return response()->json(['message' => 'No applications found'], 404);
        }
        return response()->json($applications);
    }
    public function show($id)
    {
        $application = Application::find($id);
        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }
        return response()->json($application);
    }
    public function store(Request $request)
    {
        $request->validate([
            'offer_id' => 'required|exists:offers,id',
            'user_id' => 'required|exists:users,id',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        try {
            $resumePath = $request->file('resume')->store('resumes', 'public');
            
            if (!$resumePath) {
                return response()->json(['message' => 'Failed to save resume file'], 500);
            }

            $application = Application::create([
                'offer_id' => $request->offer_id,
                'user_id' => $request->user_id,
                'resume_path' => $resumePath
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error saving file: ' . $e->getMessage()], 500);
        }

        return response()->json($application, 201);
    }
    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        
        // Delete resume file
        if (file_exists(public_path('storage/' . $application->resume_path))) {
            unlink(public_path('storage/' . $application->resume_path));
        }
        
        $application->delete();
        
        return response()->json(null, 204);
    }
    public function showResume($id)
    {
        $application = Application::find($id);
        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }
        
        $filePath = public_path('storage/' . $application->resume_path);
        
        if (!file_exists($filePath)) {
            echo $filePath;
            return response()->json(['message' => 'Resume file not found'], 404);
        }
        
        return response()->download($filePath);
    }
}
