<?php

namespace packages\Domain;

interface ITaskRepository
{
    public function getAll($currentUserId);

    public function store($task);

    public function findById($id, $currentUserId);

    public function update($task);

    public function destroy($task);
}