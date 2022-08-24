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
    public static function newListLimitForUser($query)
    {
        $newSizeLimit = 20;
        $arrPageSize = [20, 50, 100];
        if (isset($query['per_page'])) {
            $newSizeLimit = (($query['per_page'] === '') || !in_array($query['per_page'], $arrPageSize)) ? $newSizeLimit : $query['per_page'];
        }
        if (((isset($query['per_page']))) && (!empty($query->query('per_page')))) {
            $newSizeLimit = (!in_array($query->query('per_page'), $arrPageSize)) ? $newSizeLimit : $query->query('per_page');
        }
        return $newSizeLimit;
    }

    // public static function newListLimitCustom($query, $newSizeLimit = 20, $name, $arrPageSize = [],)
    // {
    //     if ($name == null) {
    //         $name = 'limit_page';
    //     }
    //     if (isset($query[$name])) {
    //         $newSizeLimit = (($query[$name] === '') || !in_array($query[$name], $arrPageSize)) ? $newSizeLimit : $query[$name];
    //     }
    //     if (((isset($query[$name]))) && (!empty($query->query($name)))) {
    //         $newSizeLimit = (!in_array($query->query($name), $arrPageSize)) ? $newSizeLimit : $query->query($name);
    //     }
    //     return $newSizeLimit;
    // }

    /**
     * [escapeLikeSentence description]
     * @param  [type]  $str    :search conditions
     * @param  boolean $before : add % before
     * @param  boolean $after  : add % after
     * @return [type]          [description]
     */
    public function escapeLikeSentence($column, $str, $before = true, $after = true)
    {
        $result = str_replace('\\', '[\]', $this->mbTrim($str)); // \ -> \\
        $result = str_replace('%', '\%', $result); // % -> \%
        $result = str_replace('_', '\_', $result); // _ -> \_
        return [[$column, 'LIKE', (($before) ? '%' : '') . $result . (($after) ? '%' : '')]];
    }

    public function handleSearchQuery($str, $before = true, $after = true)
    {
        $result = str_replace('\\', '[\]', $this->mbTrim($str)); // \ -> \\
        $result = str_replace('%', '\%', $result); // % -> \%
        $result = str_replace('_', '\_', $result); // _ -> \_
        return (($before) ? '%' : '') . $result . (($after) ? '%' : '');
    }

    public function checkPaginatorList($query)
    {
        if ($query->currentPage() > $query->lastPage()) {
            return true;
        }
        return false;
    }

    public function mbTrim($string)
    {
        $whitespace = '[\s\0\x0b\p{Zs}\p{Zl}\p{Zp}]';
        $ret = preg_replace(sprintf('/(^%s+|%s+$)/u', $whitespace, $whitespace), '', $string);
        return $ret;
    }

    /**
     * マルチバイト対応のtrim
     *
     * 文字列先頭および最後の空白文字を取り除く
     *
     * @param  string  空白文字を取り除く文字列
     * @return  string
     *
     */

    public function checkRfidCode($rfidCode)
    {
        return preg_match('/^[a-zA-Z0-9][a-zA-Z0-9]*$/i', $rfidCode);
    }

    public function checkReturnCsvContent($column)
    {
        $ret = 0;
        if ($column == '') {
            $ret = 1; // Blank OR NULL
        } elseif (!$this->checkRfidCode($column)) {
            $ret = 2; // Error formart
        }
        return $ret;
    }

    public function logInfo($request, $message = '')
    {
        Log::channel('access_log')->info([
            'url' => url()->full(),
            'method' => $request->getMethod(),
            'data' => $request->all(),
            'message' => $message,
        ]);
    }
    public function logError($request, $message = '')
    {
        Log::channel('access_log')->error([
            'url' => url()->full(),
            'method' => $request->getMethod(),
            'data' => $request->all(),
            'message' => $message,
        ]);
    }
    public function logWarning($request, $message = '')
    {
        Log::channel('access_log')->warning([
            'url' => url()->full(),
            'method' => $request->getMethod(),
            'data' => $request->all(),
            'message' => $message,
        ]);
    }

    public function convertShijis($text)
    {
        return mb_convert_encoding($text, "SJIS", "UTF-8");
    }

}
