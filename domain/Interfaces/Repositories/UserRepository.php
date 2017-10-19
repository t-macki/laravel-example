<?php
namespace Domain\Interfaces\Repositories;

interface UserRepository
{
    public function first($field, $value, $columns = ['*']);
    public function create(array $inputs);
    public function update(array $inputs, $id);
    public function find($id);
    public function verifyDone($id);
}
