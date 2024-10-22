<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        // 未ログインはsigninにリダイレクト
        $this->middleware('auth');
    }

    public function index()
    {
        $tasksNew = Task::query()
                     ->where('status', 'N')
                     ->paginate(5, ["*"], 'new');

        $tasksPro = Task::query()
                     ->where('status', 'P')
                     ->paginate(5, ["*"], 'progress');

        $tasksEnd = Task::query()
                     ->where('status', 'E')
                     ->paginate(5, ["*"], 'end');

        return view('task.index', [
            'tasksNew' => $tasksNew,
            'tasksPro' => $tasksPro,
            'tasksEnd' => $tasksEnd,
        ]);
    }

    public function detail(Request $request, $id = '')
    {
        $task = new Task;
        $task = Task::find($id);

        return view('task.detail', [
            'task' => $task,
        ]);
    }
}
