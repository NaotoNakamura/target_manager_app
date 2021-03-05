<?php

namespace packages\Infrastructure;

use packages\Domain\ITargetRepository;
use packages\Domain\Target;
use packages\Domain\Task;
use App\Models\Target as TargetModel;
use App\Models\Task as TaskModel;

class TargetRepository implements ITargetRepository
{
    public function getAll($currentUserId) {
      $allTargets = TargetModel::with('tasks')
      ->where('user_id', $currentUserId)
      ->get()
      ->map(function ($targets) {
        return new Target(
          $targets["id"],
          $targets["user_id"],
          $targets["target_title"],
          $targets["tasks"]
        );
      })->toArray();
      return $allTargets;
    }

    public function store($target) {
      TargetModel::create([
        'target_title' => $target->title(),
        'user_id' => $target->userId(),
      ]);
    }

    public function findById($id, $currentUserId) {
      $allTargets = TargetModel::where('id', $id)->where('user_id', $currentUserId)->firstOrFail();
      $targets = new Target(
          $allTargets["id"],
          $allTargets["user_id"],
          $allTargets["target_title"],
          $allTargets["tasks"],
      );
      return $targets;
    }

    public function update($target) {
      TargetModel::where('id', $target->id())->where('user_id', $target->UserId())->update(
        [
          'id' => $target->id(),
          'target_title' => $target->title(),
          'user_id' => $target->UserId(),
        ]
      );
    }

    public function destroy($target) {
      TargetModel::where('id', $target->id())->where('user_id', $target->UserId())->delete();
    }
}
