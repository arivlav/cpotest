<?php
namespace App\Mail\Task;

use App\Models\TaskModel;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskCreated extends Mailable
{
    use Queueable, SerializesModels;

    public TaskModel $task;

    public function __construct(TaskModel $task)
    {
        $this->task = $task;
    }

    public function build()
    {
        return $this->subject('New Task created: ' . $this->task->title)
            ->view('emails.task.task_created')
            ->with(['task' => $this->task]);
    }
}


