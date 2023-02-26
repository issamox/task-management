<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task = Task::create([
            'title'       => $request->title,
            'user_id'     => Auth::user()->id,
            'project_id'  => $request->project_id,
            'assign_to'   => $request->assign_to,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Task created successfully',
            'task'    => $task,
        ]);
    }

    public function updateStatus($id){
        $task = Task::find($id);
        $task->isCompleted = !$task->isCompleted;
        $task->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'The status has been updated',
        ]);
    }
}
