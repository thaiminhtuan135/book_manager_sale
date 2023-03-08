<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Repositories\Book\BookInterface;
use App\Repositories\Company\CompanyInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $book;

    public function __construct(BookInterface $book)
    {
        $this->book = $book;
    }

    public function formatArr($arr)
    {
//        $arrRemoved = [];
        $arrUnique = array_unique($arr);
        foreach ($arrUnique as $key => $item) {
            if ($item == 0) {
                unset($arrUnique[$key]);
            }
        }

        return $arrUnique;
    }

    public function index(Request $request)
    {
        $arrArmyId = [
            '147' => [14701, 14702, 14703, 14704, 14705, 14706, 14707, 14708, 14709, 14710, 14711, 14712, 14713, 14714, 14715, 14716, 14717, 14718, 14719, 14720, 14721, 14722, 14723, 14724, 14725],
        ];

        $xmlDataString = file_get_contents(public_path('skill.xml'));
        $xmlObject = simplexml_load_string($xmlDataString);

        $json = json_encode($xmlObject);
        $phpDataArray = json_decode($json, true);
        $arrXMLConvertToArrayPHP = [];
        foreach ($phpDataArray as $key => $item) {
            $arrXMLConvertToArrayPHP = $item;
        }
//        dd($phpDataArray['skill']);
        // monster
        for ($i = 0; $i < count($arrXMLConvertToArrayPHP); $i++) {
//            dd($arrXMLConvertToArrayPHP[$i]['@attributes']['htid'], $arrXMLConvertToArrayPHP[$i]['@attributes']['desc'], $arrXMLConvertToArrayPHP[$i]['@attributes']['normalAtk'], $arrXMLConvertToArrayPHP[$i]['@attributes']['rageAtkSkill'] , $arrXMLConvertToArrayPHP[$i]['@attributes']['devilFruitSkill']);
        }
        // skill
//        dd($phpDataArray['skill']);
        for ($i = 0; $i < count($phpDataArray['skill']); $i++) {
//            dd($phpDataArray['skill'][$i]['@attributes']['id'] ,$phpDataArray['skill'][$i]['@attributes']['des'] );
        }


        $newSizeLimit = $this->newListLimit($request);
        return view('admin.book.index', [
            'title' => __('Book Manager'),
            'request' => $request,
            'bookList' => $this->book->get($request),
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

        return view('admin.book.create', ['title' => __('Add book')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
//        dd($request->all());
        if ($this->book->store($request)) {
            $this->setFlash(__('AddBookSuceesful'));
            return redirect(route('book.index'));
        }
        $this->setFlash(__('Thêm sách thất bại'));
        return redirect()->route('book.create');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = $this->book->getById($id);
        if (!$book) {
            return redirect(route('book.index'));
        }
        return view('admin.book.edit', [
            'title' => __('EditBook'),
            'book' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, $id)
    {
        if ($this->book->update($request, $id)) {
            $this->setFlash(__('Success'));
            return redirect(route('book.index'));
        }
        $this->setFlash(__('Fail'));
        return redirect(route('book.update', $id));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->book->destroy($id)) {
            return response()->json([
                'message' => __('DeleteFail'),
                'status' => StatusCode::OK
            ], StatusCode::INTERNAL_ERR);
        }
        return response()->json([
            'message' => __('DeleteSuccess'),
            'status' => StatusCode::OK
        ], StatusCode::OK);
    }

    public function homeList(Request $request)
    {
        $newSizeLimit = $this->newListLimit($request);
        return view('admin.homePage.index', [
            'title' => __('Book Manager'),
            'request' => $request,
            'bookList' => $this->book->get($request),
            'newSizeLimit' => $newSizeLimit,
        ]);
    }

    public function export(Request $request)
    {
//        $books = $this->book->export($request);
//        $fileName = 'book'. Carbon::now()->format('YmdHis') . '.csv';
//        $header = [
//            'ID',
//            'Tác giả',
//            'Mô tả',
//            'Thể loại'."\n",
//            'Ngày phát hành',
//            'Số trang',
//        ];
//        if (! file_exists(public_path() . '/export_csv')) {
//            mkdir(public_path() . '/export_csv', 0777, true);
//        }
//        $localPath = public_path().'/export_csv/'.$fileName;
//        $file = fopen($localPath, 'w');
//        fwrite($file, "\xEF\xBB\xBF");
//        fputcsv($file, $header);
//        foreach ($books as $key => $book) {
//            $row = [
//                $book->id,
//                $book->author,
//                $book->description,
//                $book->category,
//                Carbon::parse($book->release_date)->format('d/m/Y'),
//                $book->number_page,
//            ];
//            fputcsv($file, $row);
//        }
//        fclose($file);
//
//        return response()->json([
//            'path' => url('/export_csv/').'/'.$fileName,
//        ]);

        // game
        $copyID = [141];
        $arrArmyId = [
            '141' => [
                14101,
                14102,
                14103,
                14104,
                14105,
                14106,
                14107,
                14108,
                14109,
                14110,
                14111,
                14112,
                14113,
                14114,
                14115,
                14116,
                14117,
                14118,
                14119,
                14120,
                14121,
                14122,
                14123,
                14124,
                14125,
                14126,
                14127,
            ],
        ];
        $arrMonster = [
            '14101' => [1141011,0,1141012,1141013,0,1141014,0,1141015,0],
            '14102' => [1141021,1141022,1141023,0,1141024,0,0,1141025,0],
            '14103' => [0,0,1141031,0,1141032,1141033,1141034,1141035,0],
            '14104' => [0,1141041,0,1141042,1141043,1141044,0,1141045,0],
            '14105' => [0,0,0,0,3141051,0,0,0,0],
            '14106' => [1141061,1141062,1141063,0,2141064,0,0,1141065,0],
            '14107' => [1141071,0,1141072,1141073,0,1141074,0,1141075,0],
            '14108' => [1141081,0,0,1141082,1141083,0,0,1141084,1141085],
            '14109' => [1141091,0,1141092,0,0,0,1141093,1141094,1141095],
            '14110' => [0,1141101,0,1141102,1141103,1141104,0,1141105,0],
            '14111' => [1141111,0,1141112,0,0,0,1141113,2141114,1141115],
            '14112' => [1141121,0,0,1141122,1141123,0,0,1141124,1141125],
            '14113' => [0,1141131,0,1141132,1141133,1141134,0,1141135,0],
            '14114' => [1141141,1141142,1141143,0,1141144,0,0,1141145,0],
            '14115' => [0,0,1141151,0,1141152,1141153,1141154,1141155,0],
            '14116' => [0,1141161,0,1141162,2141163,1141164,0,1141165,0],
            '14117' => [1141171,1141172,1141173,0,1141174,0,0,1141175,0],
            '14118' => [1141181,0,1141182,0,0,0,1141183,1141184,1141185],
            '14119' => [0,0,1141191,0,1141192,1141193,1141194,1141195,0],
            '14120' => [1141201,1141202,1141203,0,1141204,0,0,1141205,0],
            '14121' => [1141211,0,1141212,0,0,0,1141213,1141214,1141215],
            '14122' => [0,1141221,0,1141222,1141223,1141224,0,1141225,0],
            '14123' => [1141231,0,1141232,0,0,0,1141233,1141234,1141235],
            '14124' => [1141241,0,0,1141242,1141243,0,0,1141244,1141245],
            '14125' => [1141251,0,1141252,0,0,0,1141253,1141254,1141255],
            '14126' => [0,2141261,0,2141262,0,0,0,2141263,0],
            '14127' => [0,0,0,0,0,0,0,3141271,0],
        ];
        // convert XML to PHP


        $xmlDataString = file_get_contents(public_path('test.xml'));
        $xmlObject = simplexml_load_string($xmlDataString);
        $json = json_encode($xmlObject);
        $phpDataArray = json_decode($json, true);
        $arrXMLConvertToArrayPHP = [];
        foreach ($phpDataArray as $key => $item) {
            $arrXMLConvertToArrayPHP = $item;
        }

        // convert skill.xml to arr php
        $xmlDataStringSkill = file_get_contents(public_path('skill.xml'));
        $xmlObjectSkill = simplexml_load_string($xmlDataStringSkill);
        $jsonSkill = json_encode($xmlObjectSkill);
        $phpDataArraySkill = json_decode($jsonSkill, true);

        // convert XML to PHP
        $books = $this->book->export($request);

        $fileName = 'book' . Carbon::now()->format('YmdHis') . '.csv';
        $header = ['Copy ID', 'Army ID', 'ID Quái', 'Mô tả', 'ID', 'Mô tả', 'ID', 'Mô tả', 'ID', 'Mô tả'];
        if (!file_exists(public_path() . '/export_csv')) {
            mkdir(public_path() . '/export_csv', 0777, true);
        }
        $localPath = public_path() . '/export_csv/' . $fileName;
        $file = fopen($localPath, 'w');
        fwrite($file, "\xEF\xBB\xBF");
        fputcsv($file, $header);
        foreach ($copyID as $keyCopyId => $ID) {
            $checkID = true;
            foreach ($arrArmyId[$ID] as $keyArmyID => $armyID) {
                $check = true;
                foreach ($this->formatArr($arrMonster[$armyID]) as $keyMonsterId => $monsterID) {

                    for ($i = 0; $i < count($arrXMLConvertToArrayPHP); $i++) {
                        if ($arrXMLConvertToArrayPHP[$i]['@attributes']['htid'] == $monsterID) {

                            $desSkillNormal = '';
                            $desSkillRange = '';
                            for ($a = 0; $a < count($phpDataArraySkill['skill']); $a++) {
                                if ($arrXMLConvertToArrayPHP[$i]['@attributes']['normalAtk'] == $phpDataArraySkill['skill'][$a]['@attributes']['id']) {
                                    $desSkillNormal = $phpDataArraySkill['skill'][$a]['@attributes']['des'];
                                }

                                if ($arrXMLConvertToArrayPHP[$i]['@attributes']['rageAtkSkill'] == $phpDataArraySkill['skill'][$a]['@attributes']['id']) {
                                    $desSkillRange = $phpDataArraySkill['skill'][$a]['@attributes']['des'];
                                }
                            }

                            if ($check && $checkID) {
                                $row = [
                                    $ID, $armyID, $monsterID,
                                    $arrXMLConvertToArrayPHP[$i]['@attributes']['desc'],
                                    0,
                                    '',
                                    $arrXMLConvertToArrayPHP[$i]['@attributes']['normalAtk'],
                                    $desSkillNormal,
                                    $arrXMLConvertToArrayPHP[$i]['@attributes']['rageAtkSkill'],
                                    $desSkillRange
                                ];
                                fputcsv($file, $row);
                                $checkID = false;
                            } else if ($check) {
                                $row = ["", $armyID, $monsterID,
                                    $arrXMLConvertToArrayPHP[$i]['@attributes']['desc'],
                                    0,
                                    '',
                                    $arrXMLConvertToArrayPHP[$i]['@attributes']['normalAtk'],
                                    $desSkillNormal,
                                    $arrXMLConvertToArrayPHP[$i]['@attributes']['rageAtkSkill'],
                                    $desSkillRange
                                ];
                                fputcsv($file, $row);
                                $check = false;
                            } else {
                                $row = ["", "", $monsterID,
                                    $arrXMLConvertToArrayPHP[$i]['@attributes']['desc'],
                                    0,
                                    '',
                                    $arrXMLConvertToArrayPHP[$i]['@attributes']['normalAtk'],
                                    $desSkillNormal,
                                    $arrXMLConvertToArrayPHP[$i]['@attributes']['rageAtkSkill'],
                                    $desSkillRange
                                ];
                                fputcsv($file, $row);
                            }

                        }
                    }
                }
//                $check = true;
            }
//            $checkID = true;
        }
        fclose($file);

        return response()->json([
            'path' => url('/export_csv/') . '/' . $fileName,
        ]);
    }

    public function checkNameBook(Request $request)
    {
        return response()->json([
            'valid' => $this->book->checkNameBook($request),
        ], StatusCode::OK);
    }

}
