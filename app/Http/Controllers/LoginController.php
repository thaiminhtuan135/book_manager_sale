<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        dd($request->all());
        return view('login.index', [
            'title' => __('LoginManager'),
            'message' => $request->message,
            'request' => $request->all(),
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
//        $data = [
//            'email' => $request->email,
//            'password' => $request->password,
//        ];
        $credentials = $request->only('email', 'password');

        if (Auth::guard('user')->attempt($credentials)) {
            if(Auth::guard('user')->user()->role_id != UserRole::SYSTEM_ADMIN) {
//                Auth::guard('user')->logout();
                return redirect(route('product.index'));
            }
            $this->setFlash(__('LoginSuccess'));
            return redirect(route('book.index'));
        }
        return redirect(route('login.index',['message'=> __('Alert')]));
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

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect(route('login.index'));
    }
}
