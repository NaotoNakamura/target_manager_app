<?php

namespace packages\UseCase;

use packages\Domain\ITargetRepository;
use packages\Domain\Target;

class TargetStoreUseCase
{
    protected $targetRepository;

    public function __construct(ITargetRepository $targetRepository)
    {
        $this->targetRepository = $targetRepository;
    }

    public function handle($request, $currentUserId)
    {
        $target = new Target(
            $request["id"],
            $currentUserId,
            $request["target_title"],
            $request["tasks"]
        );
        $this->targetRepository->store($target);
    }
}