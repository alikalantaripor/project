<?php

namespace App\Http\Livewire;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Main extends Component
{

    public $users;
    public $todoList;
    public $doingList;
    public $doneList;

    public function render()
    {
        $this->getList();
        return view('livewire.main')->layout('layout.app');
    }

    public function getList()
    {
        $this->users = User::all();
        $this->todoList = Task::where('status', 'todo')->get();
        $this->doingList = Task::where('status', 'doing')->get();
        $this->doneList = Task::where('status', 'done')->get();
    }

    public function statusUpdate($formData)
    {
        $task = Task::where('id', $formData['id'])->first();
        $task->status = $formData['status'];
        $task->update();
        redirect('/');
    }

    public function taskStore($formData)
    {
        $task = new Task();
        $task->title = $formData['title'];
        $task->dueTime = $formData['dueTime'];
        $task->save();
        DB::table('task_user')->insert(['user_id' => $formData['member'], 'task_id' => $task->id]);
        $this->getList();

    }
}
