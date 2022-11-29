<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Http\Requests\UserRequest;
use App\Repositories\Company\CompanyInterface;
use App\Repositories\Users\UsersInterface;
use App\Repositories\Users\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;

class RegisterController extends BaseController
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

    public function index()
    {
        return view('login.register');
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
    public function store(UserRequest $request)
    {
        //
//        dd($request->all());
        try {
            DB::statement("SET SQL_MODE=''");
            DB::beginTransaction();
            for ($i = 0; $i < $request->size; $i++) {
                $data = new stdClass();
                $data->name = $request["name" . $i];
                $data->address = $request["address" . $i];
                $data->dob = $request["dob" . $i];
                $data->telephone = $request["telephone" . $i];
                $data->email = $request["email" . $i];
                $data->role_id = $request["role_id"];
                $data->password = $request["password" . $i];
//                dd($data);
                $this->u->store($data);
            }

            $this->setFlash(__('RegisterSuccess'));
            DB::commit();
            return redirect(route('login.index'));

        } catch (\Exception $e) {
            return redirect()->route('register.index');
        }
//        if ($this->u->store($request)) {
//            $this->setFlash(__('RegisterSuccess'));
//            return redirect(route('login.index'));
//        }


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

    public function checkEmail(Request $request)
    {
        return response()->json([
            'valid' => $this->u->checkMail($request),
        ], StatusCode::OK);
    }
}
