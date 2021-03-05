<?php

namespace packages\Domain;

class Target {

    private $id;
    private $userId;
    private $title;
    private $tasks;

    public function __construct($id, $userId, $title, $tasks)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->tasks = $tasks;
    }

    public function id()
    {
        return $this->id;
    }

    public function userId()
    {
        return $this->userId;
    }

    public function title()
    {
        return $this->title;
    }

    public function tasks()
    {
        return $this->tasks->toArray();
    }
}
