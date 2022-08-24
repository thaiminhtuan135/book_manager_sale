<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Http\Controllers\BaseController;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Repositories\Company\CompanyInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class CompanyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $company;

    public function __construct(CompanyInterface $company)
    {
        $this->company = $company;
    }

    public function index(Request $request)
    {
//        dd($companyList);
//        dd($request->all());
        $newSizeLimit = $this->newListLimit($request);
        return view('admin.company.index', [
            'title'=>'Danh sách',
            'request' => $request,
            'companyList' => $this->company->get($request),
            'newSizeLimit' => $newSizeLimit,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.company.create', ['title' => 'Thêm công ty']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        if ($this->company->store($request)) {
            $this->setFlash(__('Đăng kí công ty thành công'));
            return redirect(route('company.index'));
        }
        return redirect()->route('company.create');
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
        $company = $this->company->getById($id);
        if (!$company) {
            return redirect(route('company.index'));
        }
        return view('admin.company.edit', [
            'title' => 'Sửa công ty',
            'company' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {
        if ($this->company->update($request,$id)) {
            $this->setFlash(__('Sửa thành công'));
            return redirect(route('company.index'));
        }
        $this->setFlash(__('Sửa thất bại'));
        return redirect(route('company.update', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->company->destroy($id)) {
            return response()->json([
                'message' => 'エラーが発生しました。',
                'status' => StatusCode::OK
            ], StatusCode::INTERNAL_ERR);
        }
    }
}
