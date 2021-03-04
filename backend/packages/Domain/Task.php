<?php

namespace packages\Domain;

class Task {
    private $id;
    private $user_id;
    private $target_id;
    private $title;
    private $period_kind;
    private $start_date;
    private $end_date;
    private $is_done;

    public function __construct(
        $id,
        $user_id,
        $target_id,
        $title,
        $period_kind,
        $start_date,
        $end_date,
        $is_done
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->target_id = $target_id;
        $this->title = $title;
        $this->period_kind = $period_kind;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->is_done = $is_done;
    }

    public function id()
    {
        return $this->id;
    }

    public function userId()
    {
        return $this->user_id;
    }

    public function targetId()
    {
        return $this->target_id;
    }

    public function title()
    {
        return $this->title;
    }

    public function periodKind()
    {
        return $this->period_kind;
    }

    public function startDate()
    {
        return $this->start_date;
    }

    public function endDate()
    {
        return $this->end_date;
    }

    public function isDone()
    {
        return $this->is_done;
    }
}