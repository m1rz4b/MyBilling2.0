<?php

namespace App\Http\Controllers;

use App\Models\TaskProgress;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Menu;

class TaskProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $task_progresses = TaskProgress::get();
        return view('pages.setup.taskProgress', compact('menus', 'task_progresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => [
                'string',
                'max:255',
                'nullable',
                Rule::unique('task_progress')->whereNull('deleted_at')
            ],
            'duration' => ['numeric', 'nullable']
        ]);

        $user_id = 1; //Replace by Auth later

        $taskProgress = TaskProgress::create([
            'description' => ($request->description==null) ? '' : $request->description,
            'duration' => ($request->duration==null) ? 0 : $request->duration,
            'created_by' => $user_id
        ]);

        return redirect(route('taskprogress.index')) -> with('success', 'Task Progress added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskProgress $taskProgress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskProgress $taskProgress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $taskProgress)
    {
        $user_id = 1; //Replace by Auth later

        $updateData = $request->validate([
            'description' => [
                'string',
                'max:255',
                'nullable',
                Rule::unique('task_progress')->ignore($taskProgress)->whereNull('deleted_at')
            ],
            'duration' => ['numeric', 'nullable']
        ]);

        $tasks = TaskProgress::find($taskProgress);
        $tasks->description = $request->description;
        $tasks->duration = $request->duration;
        $tasks->status = $request->status;
        $tasks->updated_by = $user_id;
        $tasks->update([
            'duration' => ($request->duration == null) ? 0 : $request->duration
        ]);
        $tasks->save();

        return redirect(route('taskprogress.index')) -> with('success', 'Task Progress has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($taskProgress = null)
    {
        $user_id = 1; //Replace by Auth later

        $tasks = TaskProgress::find($taskProgress);
        $tasks->deleted_by = $user_id;
        $tasks->save();
        $tasks->delete();
        return redirect(route('taskprogress.index')) -> with('success', 'Task Progress has been deleted successfully');
    }
}
