<?php

namespace App\Repositories\Users;

use App\Http\Controllers\Mail\ForgotPasswordComplete;
use App\Models\User;
use App\Http\Controllers\BaseController;
use App\Repositories\Users\UsersInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\Concerns\Has;

class UsersRepository extends BaseController implements UsersInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
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
        return $this->user->create([
            'name' => $request->name,
            'address' => $request->address,
            'dob' => $request->dob,
            'role_id' => $request->role_id,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'customer_id' => $request->customer_id,
        ]);
//        $userInfo = $this->user;
//        DB::beginTransaction();
//        $userInfo->name = $request->name;
//        $userInfo->address = $request->address;
//        $userInfo->dob = $request->dob;
//        $userInfo->role_id = $request->role_id;
//        $userInfo->telephone = $request->telephone;
//        $userInfo->email = $request->email;
//        $userInfo->password = Hash::make($request->password);
//        if ($userInfo->save()) {
//            DB::commit();
//            return true;
//        }
//        DB::rollBack();
//        return false;
    }

    public function update($request, $id)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    public function checkMail($request)
    {
        return !$this->user->where(['email' => $request['value']])->exists();
    }

    public function checkMailForgotPassword($request)
    {

        return $this->user->where(['email' => $request['email']])->exists();
    }

    public function resetPass($request)
    {
        $userInfo = $this->user->where('email', $request->email)->first();
        if (!$userInfo) {
            return false;
        }
//        $strPass = Str::random(8);

//        $userInfo->password = Hash::make($strPass);
        $userInfo->code = Str::random(6);
        if (!$userInfo->save()) {
            return false;
        }

        $mailData = [
//            'password' => $strPass,
            'code' => $userInfo->code,
            'link' => route('reset_password.index')
        ];
        Mail::to($userInfo->email)->send(new ForgotPasswordComplete($mailData));

        return true;

    }

    public function savePass($user, $request)
    {
        $user->password = Hash::make($request->password);
        $user->code = null;
        if (!$user->save()) {
            return false;
        }

        return true;
    }

}
