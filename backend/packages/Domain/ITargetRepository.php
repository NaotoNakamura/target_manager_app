<?php

namespace packages\Domain;

interface ITargetRepository
{
    public function getAll($currentUserId);

    public function store($target);

    public function findById($id, $currentUserId);

    public function update($target);

    public function destroy($target);
}