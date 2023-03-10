<?php

namespace App\Repositories\Users;

interface UsersInterface
{
    public function get($request);
    public function getById($id);
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
    public function checkMail($request);
    public function checkMailForgotPassword($request);
    public function resetPass($request);
    public function savePass($user ,$request);
}
