<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\OperationLog;
use App\Enums\OperationType;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Log;
use Illuminate\Routing\Route;

class BaseController extends Controller
{
    public function setFlash($message, $mode = 'success', $urlRedirect = '')
    {
        session()->forget('Message.flash');
        session()->push('Message.flash', [
            'message' => $message,
            'mode' => $mode,
            'urlRedirect' => $urlRedirect,
        ]);
    }
    public static function newListLimit($query)
    {
        $newSizeLimit = 20;
        $arrPageSize = [20, 50, 100];
        if (isset($query['limit_page'])) {
            $newSizeLimit = (($query['limit_page'] === '') || in_array($query['limit_page'], $arrPageSize)) ? $newSizeLimit : $query['limit_page'];
        }
        if (((isset($query['limit_page']))) && (!empty($query->query('limit_page')))) {
            $newSizeLimit = (!in_array($query->query('limit_page'), $arrPageSize)) ? $newSizeLimit : $query->query('limit_page');
        }
        return $newSizeLimit;
    }
    public function checkPaginatorList($query)
    {
        if ($query->currentPage() > $query->lastPage()) {
            return true;
        }
        return false;
    }

}
