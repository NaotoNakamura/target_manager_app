<?php

namespace packages\UseCase;

use packages\Domain\ITargetRepository;
use packages\Domain\Target;

class TargetUpdateUseCase
{
    protected $targetRepository;

    public function __construct(ITargetRepository $targetRepository)
    {
        $this->targetRepository = $targetRepository;
    }

    public function handle($id, $currentUserId, $request)
    {
        $target = new Target(
            $id,
            $currentUserId,
            $request["target_title"],
            $request["tasks"],
        );
        $this->targetRepository->update($target);
    }
}