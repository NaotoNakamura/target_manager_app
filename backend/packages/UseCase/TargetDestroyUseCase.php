<?php

namespace packages\UseCase;

use packages\Domain\ITargetRepository;

class TargetDestroyUseCase
{
    protected $targetRepository;

    public function __construct(ITargetRepository $targetRepository)
    {
        $this->targetRepository = $targetRepository;
    }

    public function handle($id, $currentUserId)
    {
        $target = $this->targetRepository->findById($id, $currentUserId);
        $this->targetRepository->destroy($target);
    }
}
