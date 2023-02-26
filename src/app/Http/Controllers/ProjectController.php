<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $projects = Project::orderBy('created_at','DESC')->paginate(12);
        return response()->json([
            'status' => 'success',
            'projects' => $projects,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $project = Project::create([
            'title' => $request->title,
           // 'description' => $request->description,
            'user_id'     => Auth::user()->id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Project created successfully',
            'project' => $project,
        ]);
    }

    public function show($id)
    {
        $project = Project::with('tasks')->find($id);
        return response()->json([
            'status' => 'success',
            'project' => $project,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $project = Project::find($id);
        $project->title = $request->title;
        $project->description = $request->description;
        $project->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Project updated successfully',
            'project' => $project,
        ]);
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        $project->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Project deleted successfully',
            'project' => $project,
        ]);
    }
}
