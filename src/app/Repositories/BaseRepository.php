<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = resolve($this->model())->query();
    }

    abstract public function model(): string;
}
