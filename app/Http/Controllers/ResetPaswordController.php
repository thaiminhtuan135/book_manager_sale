<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Users\UsersInterface;
use Illuminate\Http\Request;

class ResetPaswordController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $u;

    public function __construct(UsersInterface $user)
    {
        $this->u = $user;
    }

    public function index(Request $request)
    {
        return view('reset_password.index',[
            'request' => $request
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userInfo = User::where('code', $request->code)->first();

        if (!$userInfo) {
            $this->setFlash(__('Không có người dùng'), 'error');
            return redirect()->route('reset_password.index');
        }
        if (!$this->u->savePass($userInfo,$request)) {
            $this->setFlash(__('Đặt lại mật khẩu thất bại'), 'error');
            return redirect()->route('reset_password.index');
        }
        $this->setFlash(__('Đặt lại mật khẩu thành công'));
        return redirect()->route('login.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
