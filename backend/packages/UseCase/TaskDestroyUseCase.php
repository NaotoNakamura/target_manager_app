<?php

namespace packages\UseCase;

use packages\Domain\ITaskRepository;

class TaskDestroyUseCase
{
    protected $taskRepository;

    public function __construct(ITaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle($id, $currentUserId)
    {
        $task = $this->taskRepository->findById($id, $currentUserId);
        $this->taskRepository->destroy($task);
    }
}
