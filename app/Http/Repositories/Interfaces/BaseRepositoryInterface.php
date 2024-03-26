<?php

namespace App\Http\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function getAll($paginate = null);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
