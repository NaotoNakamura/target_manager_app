<?php

namespace packages\UseCase;

use packages\Domain\ITaskRepository;

class TaskIndexUseCase
{
    protected $taskRepository;

    public function __construct(ITaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle($currentUserId)
    {
        $allTasks = $this->taskRepository->getAll($currentUserId);
        $result = array_map(function ($tasks) {
            return [
                "id" => $tasks->id(),
                "user_id" => $tasks->userId(),
                "target_id" => $tasks->targetId(),
                "task_title" => $tasks->title(),
                "period_kind" => $tasks->periodKind(),
                "start_date" => $tasks->startDate(),
                "end_date" => $tasks->endDate(),
                "is_done" => $tasks->isDone(),
            ];
        }, $allTasks);
        return $result;
    }
}
