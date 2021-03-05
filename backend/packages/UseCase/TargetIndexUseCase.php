<?php

namespace packages\UseCase;

use packages\Domain\ITargetRepository;

class TargetIndexUseCase
{
    protected $targetRepository;

    public function __construct(ITargetRepository $targetRepository)
    {
        $this->targetRepository = $targetRepository;
    }

    public function handle($currentUserId)
    {
        $allTargets = $this->targetRepository->getAll($currentUserId);
        $result = array_map(function ($targets) {
            return [
                "id" => $targets->id(),
                "user_id" => $targets->userId(),
                "title" => $targets->title(),
                "tasks" => $targets->tasks()
            ];
        }, $allTargets);
        return $result;
    }
}
