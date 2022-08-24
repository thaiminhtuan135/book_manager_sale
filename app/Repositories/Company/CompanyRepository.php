<?php

namespace App\Repositories\Company;

use App\Http\Controllers\BaseController;
use App\Models\Company;
use App\Repositories\Company\CompanyInterface;
use Illuminate\Support\Facades\DB;

class CompanyRepository extends BaseController implements CompanyInterface
{
    private Company $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function get($request)
    {
        $newSizeLimit = $this->newListLimit($request);

        $companyBuilder = $this->company;
        $companies = $companyBuilder->paginate($newSizeLimit);
//        dd($companies);
        if ($this->checkPaginatorList($companies)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $companies = $companyBuilder->paginate($newSizeLimit);
        }
        return $companies;
    }

    public function getById($id)
    {
        return $this->company->where('id', $id)->first();
    }

    public function store($request)
    {
        DB::beginTransaction();
        $this->company->code = $request->code;
        $this->company->name = $request->name;
        $this->company->telephone = $request->telephone;
        $this->company->address = $request->address;
        if ($this->company->save()) {
            DB::commit();
            return true;
        }
        DB::rollBack();
        return false;
    }

    public function update($request, $id)
    {
        $companyInfo = $this->company->where('id', $id)->first();
        if (!$companyInfo) {
            return false;
        }
        DB::beginTransaction();
        $companyInfo->code = $request->code;
        $companyInfo->name = $request->name;
        $companyInfo->telephone = $request->telephone;
        $companyInfo->address = $request->address;
        if ($companyInfo->save()) {
            DB::commit();
            return true;
        }
        DB::rollBack();
        return false;
    }

    public function destroy($id)
    {
        $companyInfo = $this->company->where('id', $id)->first();
        if (!$companyInfo) {
            return false;
        }
        return $companyInfo->delete();
    }
}
