<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Task::latest()->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valdating the incoming task creation request.
        $taskAttrs = $request->validate([
            'name' => ['string', 'required', 'min:3'],
            'description' => ['string', 'required'],
            'deadline' => ['required', 'date'],
        ]);
        // Creating task record in database.
        Task::create($taskAttrs + ['user_id' => auth()->id()]);

        // returning task index page
        return redirect(route('dashboard'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return $task;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        // Checking if the request user is the owner;
        if(auth()->user()->id != $task->user->id) {
            abort(403);
        }

        // Valdating the incoming task update request.
        $taskAttrs = $request->validate([
            'name' => ['string', 'required', 'min:3'],
            'description' => ['string', 'required'],
            'deadline' => ['required', 'date'],
        ]);

        $task->update($taskAttrs);

        return redirect(route('dashboard'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        // Checking if the request user is the owner;
        if(auth()->user()->id != $task->user->id) {
            abort(403);
        }
        // deleting the task
        $task->delete();
        return redirect(route('tasks.index'));
    }
}
