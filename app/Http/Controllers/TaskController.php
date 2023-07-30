<?php

namespace App\Http\Controllers;

use App\Models\task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $task = new task;
        // $task= $task->get();
        $task= $task->paginate(5);
        // return view('tasks/index');
        return view('admin.tasks.index', compact('task'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task= new task;
        $validate_data = $request->validate([
            'title'=>'required',
            'description'=>'required',
            'img'=>'required',

        ]);
        
        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            // The file is valid and can be uploaded
            $fileName = $request->title . "-" . time() . '.' . $request->img->extension();
            $request->img->move(public_path('uploads'), $fileName);
            }

        $task->title=$request->title;
        $task->description=$request->description;
        $task->img =  $fileName;
        $task->save();
        notify()->success('Laravel Notify is awesome!');
        return redirect()->route('task.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = new Task;
        $task =$task->where('id', $id)->first();
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = new Task;
        $task =$task->where('id', $id)->first();
        return view('admin.tasks.edit', compact('task'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tasks = New Task;
        $tasks = $tasks -> where('id', $id)->First();
        $tasks->title = $request->title;
        $tasks->description = $request->description;

        if ($request->img != NULL) {
            $fileName = $request->title . "-" . time() . '.' . $request->img->extension();
            File::delete(public_path('uploads/' . $tasks->img));
            $request->img->move(public_path('uploads'), $fileName);
            $tasks::where('id', $id)
                ->update([
                    'img' => $fileName,
                ]);
        }


        $tasks->update();
        notify()->success('Laravel Notify is awesome!');
        return redirect()->route('task.index');
    }



    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $task=  $task->where('id', $id)->first();
        // $task->delete();
        // return redirect('task');
        $task = new Task;
        $task = $task->where('id', $id)->first();
        File::delete(public_path('uploads/' . $task->img));
        $task->delete();
        notify()->success('Laravel Notify is awesome!');
        return redirect()->route('task.index');
    }
}
