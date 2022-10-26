<?php

namespace App\Repositories\Book;

interface BookInterface
{
    public function get($request);
    public function getById($id);
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
}
