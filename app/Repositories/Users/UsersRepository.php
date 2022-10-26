<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Http\Controllers\BaseController;
use App\Repositories\Users\UsersInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        $userInfo = $this->user;
        DB::beginTransaction();
        $userInfo->name = $request->name;
        $userInfo->address = $request->address;
        $userInfo->dob = $request->dob;
        $userInfo->role_id = $request->role_id;
        $userInfo->telephone = $request->telephone;
        $userInfo->email = $request->email;
        $userInfo->password = Hash::make($request->password);
        if ($userInfo->save()) {
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
        // TODO: Implement destroy() method.
    }
    public function checkMail($request){
        return !$this->user->where(['email' => $request['value']])->exists();
    }
}
