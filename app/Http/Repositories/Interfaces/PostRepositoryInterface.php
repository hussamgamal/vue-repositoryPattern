<?php

namespace App\Http\Repositories\Interfaces;

interface PostRepositoryInterface
{
    public function like(int $id);
    public function attachImage();
    public function findById(int $id);
}
