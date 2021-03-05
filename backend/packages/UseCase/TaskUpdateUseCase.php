<?php

namespace packages\UseCase;

use packages\Domain\Task;
use packages\Domain\ITaskRepository;

class TaskUpdateUseCase
{
    protected $taskRepository;

    public function __construct(ITaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle($request, $id, $currentUserId)
    {
        $tasks = new Task(
            $id,
            $currentUserId,
            $request["target_id"],
            $request["task_title"],
            $request["period_kind"],
            $request["start_date"],
            $request["end_date"],
            $request["is_done"]
        );
        $this->taskRepository->update($tasks);
    }
}