<?php

namespace packages\UseCase;

use packages\Domain\ITaskRepository;
use packages\Domain\Task;

class TaskStoreUseCase
{
    protected $taskRepository;

    public function __construct(ITaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle($request, $currentUserId)
    {
        $task = new Task(
            null,
            $currentUserId,
            $request["target_id"],
            $request["task_title"],
            $request["period_kind"],
            $request["start_date"],
            $request["end_date"],
            false
        );
        $this->taskRepository->store($task);
    }
}