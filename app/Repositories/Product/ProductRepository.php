<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Http\Controllers\BaseController;
use App\Repositories\Product\ProductInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseController implements ProductInterface
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function get($request)
    {
        // TODO: Implement get() method.
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    public function store($request)
    {
        DB::beginTransaction();


        $user = Auth::guard('user')->user();
        $productInfor = $this->product->where('user_id', $user->id)
            ->where('book_id', $request->book_id)->first();

        if ($productInfor) {
            $productInfor->amount = $productInfor->amount + $request->amount;
            if ($productInfor->save()) {
                DB::commit();
                return true;
            }
        }

        $this->product->book_id = $request->book_id;
        $this->product->user_id = Auth::guard('user')->user()->id;
        $this->product->amount = $request->amount;
        if ($this->product->save()) {
            DB::commit();
            return true;
        }
        DB::rollBack();
        return false;
    }

    public function update($request, $id)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        $productInfo = $this->product->where('id', $id)->first();
        if (!$productInfo) {
            return false;
        }
        return $productInfo->delete();
    }

    public function getCardDetail($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $productBuilder = $this->product;

        $productBuilder = $productBuilder->with('books')->where('user_id', Auth::guard('user')->user()->id);


//        if (isset($request['search_input'])) {
//            $insuranceBuilder = $insuranceBuilder->where(function ($q) use ($request) {
//                $q->orWhere($this->escapeLikeSentence('insurance.name', $request['search_input']));
//            });
//        }

//        $insurances = $insuranceBuilder->sortable(['new_ts' => 'desc'])->paginate($newSizeLimit);
        $products = $productBuilder->paginate(10);
        return $products;
    }
}
