<?php

namespace packages\UseCase;

use packages\Domain\ITaskRepository;

class TaskShowUseCase
{
    protected $taskRepository;

    public function __construct(ITaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle($id, $currentUserId)
    {
        $target = $this->taskRepository->findById($id, $currentUserId);
        return [
            'id' => $target->id(),
            'user_id' => $target->userId(),
            'target_id' => $target->targetId(),
            'task_title' => $target->title(),
            'period_kind' => $target->periodKind(),
            'start_date' => $target->startDate(),
            'end_date' => $target->endDate(),
            'is_done' => $target->isDone()
        ];
    }
}