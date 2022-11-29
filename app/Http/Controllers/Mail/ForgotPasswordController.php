<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Repositories\Users\UsersInterface;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class ForgotPasswordController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $user;

    public function __construct(UsersInterface $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $message = $request->message;
        return view('forgot_pasword.index',[
            'title' => 'Quên mật khẩu',
            'request' => $request->all(),
            'message' => $message,
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
        if (!$this->user->checkMailForgotPassword($request)) {
            $this->setFlash(__('Email của bạn không đúng vui lòng nhập lại'), 'error');
            return redirect()->route('forgot_password.index');
        }

        $this->user->resetPass($request);
        $this->setFlash(__('Mật khẩu mới của bạn đã được gửi vào email đăng ký . Vui lòng kiểm tra email'), 'success');
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
