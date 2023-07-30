<?php

namespace App\Http\Controllers;

use App\Models\task as ModelsTask;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $tasks = ModelsTask::all();
        return view('index',compact('tasks'));
    }
}
