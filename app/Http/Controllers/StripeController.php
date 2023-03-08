<?php

namespace App\Http\Controllers;

use App\Repositories\Product\ProductRepository;
use Faker\Provider\Base;
use Illuminate\Http\Request;

class StripeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $product;

    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

    public function index(Request $request)
    {
        return view('stripe.index', [
            'product' => $this->product->getCard($request),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getSession(Request $request)
    {
        $arr = [];
        $data = $this->product->getCardDetail($request);
        $data = $data->items();

        foreach ($data as $item) {
//            $image['image'] = [$item->books->image];
            $arr[] = [
                'price_data' => [
                    'currency' => 'vnd',
                    'unit_amount' => $item->books->price,
                    'product_data' => [
                        'name' => $item->books->title,
                        'images' => [$item->books->image],
                    ],

                ],
                'quantity' => $item->amount,
            ];
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_API_KEY'));
        $checkout = $stripe->checkout->sessions->create([
            'success_url' => 'http://localhost:8000/success',
            'cancel_url' => 'http://localhost:8000/cancel',
            'line_items' => $arr,
            'mode' => 'payment',
        ]);

        $sub = $stripe->checkout->sessions->create([
            'success_url' => 'http://localhost:8000/success',
            'cancel_url' => 'http://localhost:8000/cancel',
            'line_items' => [
                [
                    'price' => 'price_1MD2ZgJ9DfixT1i3i11pf0YT',
                    'quantity' => 1,
                ],
            ],
            'mode' => 'subscription',
        ]);
        $results = [
            'oneTime' => $checkout,
            'sub' => $sub
        ];
        return $results;
//        return $checkout;
    }

    public function success(Request $request)
    {
//        dd('thanhtoanthanhcong');
//        dd('ds');
        $data = $this->product->getCardDetail($request);
        $data = $data->items();

//        $this->product->DeleteCard($data);
        if ($this->product->DeleteCard($data)) {
            $this->setFlash(__('Thanh toán thành công'));
            return redirect()->route('card.index');
        }
        $this->setFlash(__('Thanh toán thất bại'));

        return redirect()->route('card.index');
//        dd('ds');
    }

    public function webhook()
    {
        \Log::info("webhook");
        return response()->json(["status" => "success"]);
    }
}
