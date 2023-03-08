<?php

namespace App\Repositories\Product;

interface ProductInterface
{
    public function get($request);

    public function getById($id);

    public function store($request);

    public function update($request, $id);

    public function destroy($id);

    public function getCardDetail($request);

    public function getCard($request);

    public function DeleteCard($arr);

    public function storeEvaluate($book_id, $star);

}
