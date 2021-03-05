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
        $tests = $this->targetRepository->getAll($currentUserId);
        $result = array_map(function ($s) {
            return [
                "id" => $s->id(),
                "user_id" => $s->userId(),
                "title" => $s->title(),
                "tasks" => $s->tasks()
            ];
        }, $tests);
        return $result;
    }
}
