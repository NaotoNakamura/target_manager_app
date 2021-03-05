<?php

namespace packages\UseCase;

use packages\Domain\ITargetRepository;

class TargetShowUseCase
{
    protected $targetRepository;

    public function __construct(ITargetRepository $targetRepository)
    {
        $this->targetRepository = $targetRepository;
    }

    public function handle($id, $currentUserId)
    {
        $target = $this->targetRepository->findById($id, $currentUserId);
        return [
            "id" => $target->id(),
            "user_id" => $target->userId(),
            "title" => $target->title(),
            "tasks" => $target->tasks()
        ];
    }
}