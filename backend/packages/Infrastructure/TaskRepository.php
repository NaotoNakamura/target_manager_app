<?php

namespace packages\Infrastructure;

use packages\Domain\ITaskRepository;
use packages\Domain\Task;
use App\Models\Task as TaskModel;

class TaskRepository implements ITaskRepository
{
    public function getAll($currentUserId) {
      $allTasks = TaskModel::where('user_id', $currentUserId)
      ->get()
      ->map(function ($tasks) {
        return new Task(
          $tasks["id"],
          $tasks["user_id"],
          $tasks["target_id"],
          $tasks["task_title"],
          $tasks["period_kind"],
          $tasks["start_date"],
          $tasks["end_date"],
          $tasks["is_done"]
        );
      })->toArray();
      return $allTasks;
    }

    public function store($task) {
      TaskModel::create([
        'task_title' => $task->title(),
        'user_id' => $task->userId(),
        'target_id' => $task->targetId(),
        'period_kind' => $task->periodKind(),
        'start_date' => $task->startDate(),
        'end_date' => $task->endDate(),
        'is_done' => $task->isDone(),
      ]);
    }

    public function findById($id, $currentUserId) {
      $allTasks = TaskModel::where('id', $id)->where('user_id', $currentUserId)->firstOrFail();
      $tasks = new Task(
          $allTasks["id"],
          $allTasks["user_id"],
          $allTasks["target_id"],
          $allTasks["task_title"],
          $allTasks["period_kind"],
          $allTasks["start_date"],
          $allTasks["end_date"],
          $allTasks["is_done"]
      );
      return $tasks;
    }

    public function update($task) {
      TaskModel::where('id', $task->id())->where('user_id', $task->userId())->update(
        [
          'task_title' => $task->title(),
          'period_kind' => $task->periodKind(),
          'start_date' => $task->startDate(),
          'end_date' => $task->endDate(),
          'is_done' => $task->isDone()
        ]
      );
    }

    public function destroy($task) {
      TaskModel::where('id', $task->id())->where('user_id', $task->UserId())->delete();
    }
}
