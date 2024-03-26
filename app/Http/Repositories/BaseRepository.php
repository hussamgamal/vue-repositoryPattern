<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(public Model $repo)
    {
    }
    
    public function getAll($paginate = null)
    {
        if ($paginate) {
            return $this->repo->latest()->paginate($paginate);
        }
        return $this->repo->latest()->all();
    }
    public function create(array $data)
    {
        $data['user_id'] = auth()->id();
        return $this->repo->create($data);
    }
    public function update(int $id, array $data)
    {
        $repo = $this->repo->findOrFail($id);
        $repo->update($data);
        return $repo;
    }
    public function delete(int $id)
    {
        $this->repo->findOrFail($id)->delete();
    }
}
