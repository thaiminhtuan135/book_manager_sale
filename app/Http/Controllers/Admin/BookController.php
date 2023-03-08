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


    public function index(Request $request)
    {
//        $arrArmyId = [
//            '147' => [14701, 14702, 14703, 14704, 14705, 14706, 14707, 14708, 14709, 14710, 14711, 14712, 14713, 14714, 14715, 14716, 14717, 14718, 14719, 14720, 14721, 14722, 14723, 14724, 14725],
//        ];

        $xmlDataString = file_get_contents(public_path('skill.xml'));
        $xmlObject = simplexml_load_string($xmlDataString);

        $json = json_encode($xmlObject);
        $phpDataArray = json_decode($json, true);
        $arrXMLConvertToArrayPHP = [];
        foreach ($phpDataArray as $key => $item) {
            $arrXMLConvertToArrayPHP = $item;
        }

        for ($i = 0; $i < count($arrXMLConvertToArrayPHP); $i++) {
//            dd($arrXMLConvertToArrayPHP[$i]['@attributes']['htid'], $arrXMLConvertToArrayPHP[$i]['@attributes']['desc'], $arrXMLConvertToArrayPHP[$i]['@attributes']['normalAtk'], $arrXMLConvertToArrayPHP[$i]['@attributes']['rageAtkSkill'] , $arrXMLConvertToArrayPHP[$i]['@attributes']['devilFruitSkill']);
        }
        // skill
//        dd($phpDataArray['skill']);
        for ($i = 0; $i < count($phpDataArray['skill']); $i++) {
//            dd($phpDataArray['skill'][$i]['@attributes']['id'] ,$phpDataArray['skill'][$i]['@attributes']['des'] );
        }

        $arrTeam = $this->convertXMLToArrPHP('team.xml');
//        dd($arrTeam);
        $arrFormat = [];
        for ($i = 0; $i < count($arrTeam['team']); $i++) {
            $arrFormat[$arrTeam['team'][$i]['@attributes']['id']] = $this->convertStringToArray($arrTeam['team'][$i]['@attributes']['monsterID']);
        }

        $arrArmy = $this->convertXMLToArrPHP('army.xml');
        $arrArmyId = [];
        for ($i = 0; $i < count($arrArmy['army']); $i++) {
//            dd($arrArmy['army'][$i]['@attributes']['id']);
            $arrArmyId[$arrArmy['army'][$i]['@attributes']['id']] = (int)$arrArmy['army'][$i]['@attributes']['monstersquadID'];
        }

//        dd($arrArmyId);

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
        $copyID = [148, 147, 146, 145, 146, 145, 144, 143, 142, 141];
        $arrArmyId = [
            '148' => [
                14801,
                14802,
                14803,
                14804,
                14805,
                14806,
                14807,
                14808,
                14809,
                14810,
                14811,
                14812,
                14813,
                14814,
                14815,
                14816,
                14817,
                14818,
                14819,
                14820,
                14821,
                14822,
                14823,
                14824,
                14825,
            ],
            '147' => [14701, 14702, 14703, 14704, 14705, 14706, 14707, 14708, 14709, 14710, 14711, 14712, 14713, 14714, 14715, 14716, 14717, 14718, 14719, 14720, 14721, 14722, 14723, 14724, 14725],
            '146' => [14601, 14602, 14603, 14604, 14605, 14606, 14607, 14608, 14609, 14610, 14611, 14612, 14613, 14614, 14615, 14616, 14617, 14618, 14619, 14620, 14621, 14622, 14623, 14624, 14625],
            '145' => [14501, 14502, 14503, 14504, 14505, 14506, 14507, 14508, 14509, 14510, 14511, 14512, 14513, 14514, 14515, 14516, 14517, 14518, 14519, 14520, 14521, 14522, 14523, 14524, 14525, 14526],
            '144' => [14401, 14402, 14403, 14404, 14405, 14406, 14407, 14408, 14409, 14410, 14411, 14412, 14413, 14414, 14415, 14416, 14417, 14418, 14419, 14420, 14421, 14422, 14423, 14424, 14425, 14426],
            '143' => [14301, 14302, 14303, 14304, 14305, 14306, 14307, 14308, 14309, 14310, 14311, 14312, 14313, 14314, 14315, 14316, 14317, 14318, 14319, 14320, 14321, 14322, 14323, 14324, 14325, 14326],
            '142' => [14201, 14202, 14203, 14204, 14205, 14206, 14207, 14208, 14209, 14210, 14211, 14212, 14213, 14214, 14215, 14216, 14217, 14218, 14219, 14220, 14221, 14222, 14223, 14224, 14225, 14226],
            '141' => [14101, 14102, 14103, 14104, 14105, 14106, 14107, 14108, 14109, 14110, 14111, 14112, 14113, 14114, 14115, 14116, 14117, 14118, 14119, 14120, 14121, 14122, 14123, 14124, 14125, 14126, 14127],
        ];

        $arrMonsterID = [];
        $arrTeam = $this->convertXMLToArrPHP('team.xml');
        for ($i = 0; $i < count($arrTeam['team']); $i++) {
            $arrMonsterID[$arrTeam['team'][$i]['@attributes']['id']] = $this->convertStringToArray($arrTeam['team'][$i]['@attributes']['monsterID']);
        }

        // convert XML to PHP


        $phpDataArray = $this->convertXMLToArrPHP('test.xml');
        $arrMonsters = [];
        foreach ($phpDataArray as $key => $item) {
            $arrMonsters = $item;
        }

        // convert skill.xml to arr php
        $phpDataArraySkill = $this->convertXMLToArrPHP('skill.xml');

        //convert army.xml to arr php
        $arrArmy = $this->convertXMLToArrPHP('army.xml');
        $arrMonsterSquadID = [];
        for ($i = 0; $i < count($arrArmy['army']); $i++) {
            $arrMonsterSquadID[$arrArmy['army'][$i]['@attributes']['id']] = (int)$arrArmy['army'][$i]['@attributes']['monstersquadID'];
        }
        // convert XML to PHP

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
            foreach ($arrArmyId as $key => $item) {
                if ($ID == $key) {
                    foreach ($arrArmyId[$ID] as $keyArmyID => $armyID) {
                        foreach ($arrMonsterSquadID as $keyMonsterSquadID => $MonsterSquadID) {
                            if ($armyID == $keyMonsterSquadID) {
                                $check = true;
                                foreach ($arrMonsterID as $keyTeamId => $item) {
                                    if ($MonsterSquadID == $keyTeamId) {
                                        if ($armyID == $keyTeamId) {
                                            foreach ($this->formatArr($arrMonsterID[$armyID]) as $keyMonsterId => $monsterID) {
                                                for ($i = 0; $i < count($arrMonsters); $i++) {
                                                    if ($arrMonsters[$i]['@attributes']['htid'] == $monsterID) {

                                                        $desSkillNormal = '';
                                                        $desSkillRange = '';
                                                        for ($a = 0; $a < count($phpDataArraySkill['skill']); $a++) {
                                                            if ($arrMonsters[$i]['@attributes']['normalAtk'] == $phpDataArraySkill['skill'][$a]['@attributes']['id']) {
                                                                $desSkillNormal = $phpDataArraySkill['skill'][$a]['@attributes']['des'];
                                                            }

                                                            if ($arrMonsters[$i]['@attributes']['rageAtkSkill'] == $phpDataArraySkill['skill'][$a]['@attributes']['id']) {
                                                                $desSkillRange = $phpDataArraySkill['skill'][$a]['@attributes']['des'];
                                                            }
                                                        }

                                                        if ($check && $checkID) {
                                                            $row = [
                                                                $ID,
                                                                $armyID,
                                                                $monsterID,
                                                                $arrMonsters[$i]['@attributes']['desc'],
                                                                0,
                                                                '',
                                                                $arrMonsters[$i]['@attributes']['normalAtk'],
                                                                $desSkillNormal,
                                                                $arrMonsters[$i]['@attributes']['rageAtkSkill'],
                                                                $desSkillRange
                                                            ];
                                                            fputcsv($file, $row);
                                                            $checkID = false;
                                                        } else if ($check) {
                                                            $row = [
                                                                "",
                                                                $armyID,
                                                                $monsterID,
                                                                $arrMonsters[$i]['@attributes']['desc'],
                                                                0,
                                                                '',
                                                                $arrMonsters[$i]['@attributes']['normalAtk'],
                                                                $desSkillNormal,
                                                                $arrMonsters[$i]['@attributes']['rageAtkSkill'],
                                                                $desSkillRange
                                                            ];
                                                            fputcsv($file, $row);
                                                            $check = false;
                                                        } else {
                                                            $row = [
                                                                "",
                                                                "",
                                                                $monsterID,
                                                                $arrMonsters[$i]['@attributes']['desc'],
                                                                0,
                                                                '',
                                                                $arrMonsters[$i]['@attributes']['normalAtk'],
                                                                $desSkillNormal,
                                                                $arrMonsters[$i]['@attributes']['rageAtkSkill'],
                                                                $desSkillRange
                                                            ];
                                                            fputcsv($file, $row);
                                                        }

                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
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

    public function convertXMLToArrPHP($fileName)
    {
        $xmlDataString = file_get_contents(public_path($fileName));
        $xmlObject = simplexml_load_string($xmlDataString);
        $json = json_encode($xmlObject);
        $phpDataArray = json_decode($json, true);
        return $phpDataArray;
    }

    public function formatArr($arr)
    {
        $arrUnique = array_unique($arr);
        foreach ($arrUnique as $key => $item) {
            if ($item == 0) {
                unset($arrUnique[$key]);
            }
        }

        return $arrUnique;
    }

    public function convertStringToArray($arrString)
    {
        $toNumberArr = explode(",", $arrString);

        foreach ($toNumberArr as $key => $item) {
            $toNumberArr[$key] = (int)$item;
        }
        return $toNumberArr;
    }
}
