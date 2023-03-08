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

//        '136' => [13601, 13602, 13603, 13604, 13605, 13606, 13607, 13608, 13609, 13610, 13611, 13612, 13613, 13614, 13615, 13616, 13617, 13618, 13619, 13620, 13621, 13622, 13623, 13624, 13625,],
        $stringMain = '';
        $id = "109";
        $stringMain .= $id . " => [";

        for ($i = 1; $i <=27; $i++) {

            if ($i < 10) {
                $stringMain .= $id . "0" . $i . ",";
            } else {
                $stringMain .= $id . $i . ",";
            }
        }
        $stringMain .= '],';
        // dd($stringMain);

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
        $copyID = [123, 122, 121, 120, 119, 118, 117, 116, 115, 114, 113, 112, 111, 110, 109, 108, 107, 106, 105, 104, 103, 102, 101, 100, 99, 98, 97, 96, 95, 94, 93, 92, 91, 90, 89, 88, 87, 86, 85, 84, 83, 82, 81, 80, 79, 78, 77, 76, 75, 74, 73, 72, 71];
        $arrArmyId = [
//            '140' => [14001, 14002, 14003, 14004, 14005, 14006, 14007, 14008, 14009, 14010, 14011, 14012, 14013, 14014, 14015, 14016, 14017, 14018, 14019, 14020, 14021, 14022, 14023, 14024, 14025, 14026,],
//            '139' => [13901, 13902, 13903, 13904, 13905, 13906, 13907, 13908, 13909, 13910, 13911, 13912, 13913, 13914, 13915, 13916, 13917, 13918, 13919, 13920, 13921, 13922, 13923, 13924, 13925, 13926, 13927, 13928,],
//            '138' => [13801, 13802, 13803, 13804, 13805, 13806, 13807, 13808, 13809, 13810, 13811, 13812, 13813, 13814, 13815, 13816, 13817, 13818, 13819, 13820, 13821, 13822, 13823, 13824, 13825, 13826,],
//            '137' => [13701, 13702, 13703, 13704, 13705, 13706, 13707, 13708, 13709, 13710, 13711, 13712, 13713, 13714, 13715, 13716, 13717, 13718, 13719, 13720, 13721, 13722, 13723, 13724, 13725, 13726, 13727,],
//            '136' => [13601, 13602, 13603, 13604, 13605, 13606, 13607, 13608, 13609, 13610, 13611, 13612, 13613, 13614, 13615, 13616, 13617, 13618, 13619, 13620, 13621, 13622, 13623, 13624, 13625,],
//            '135' => [13501, 13502, 13503, 13504, 13505, 13506, 13507, 13508, 13509, 13510, 13511, 13512, 13513, 13514, 13515, 13516, 13517, 13518, 13519, 13520, 13521, 13522, 13523, 13524, 13525, 13526, 13527,],
//            '134' => [13401, 13402, 13403, 13404, 13405, 13406, 13407, 13408, 13409, 13410, 13411, 13412, 13413, 13414, 13415, 13416, 13417, 13418, 13419, 13420, 13421, 13422, 13423, 13424, 13425, 13426,],
//            '133' => [13301, 13302, 13303, 13304, 13305, 13306, 13307, 13308, 13309, 13310, 13311, 13312, 13313, 13314, 13315, 13316, 13317, 13318, 13319, 13320, 13321, 13322, 13323, 13324, 13325, 13326,],
//            '132' => [13201, 13202, 13203, 13204, 13205, 13206, 13207, 13208, 13209, 13210, 13211, 13212, 13213, 13214, 13215, 13216, 13217, 13218, 13219, 13220, 13221, 13222, 13223, 13224, 13225,],
//            '131' => [13101, 13102, 13103, 13104, 13105, 13106, 13107, 13108, 13109, 13110, 13111, 13112, 13113, 13114, 13115, 13116, 13117, 13118, 13119, 13120, 13121, 13122, 13123, 13124, 13125, 13126, 13127,],
//            '130' => [13001, 13002, 13003, 13004, 13005, 13006, 13007, 13008, 13009, 13010, 13011, 13012, 13013, 13014, 13015, 13016, 13017, 13018, 13019, 13020, 13021, 13022, 13023, 13024, 13025,],
//            '129' => [12901,12902,12903,12904,12905,12906,12907,12908,12909,12910,12911,12912,12913,12914,12915,12916,12917,12918,12919,12920,12921,12922,12923,12924,12925,12926,12927],
//            '128' => [12801,12802,12803,12804,12805,12806,12807,12808,12809,12810,12811,12812,12813,12814,12815,12816,12817,12818,12819,12820,12821,12822,12823,12824,12825,],
//            '127' => [12701,12702,12703,12704,12705,12706,12707,12708,12709,12710,12711,12712,12713,12714,12715,12716,12717,12718,12719,12720,12721,12722,12723,12724,12725,12726,12727,],
//            '126' => [12601,12602,12603,12604,12605,12606,12607,12608,12609,12610,12611,12612,12613,12614,12615,12616,12617,12618,12619,12620,12621,12622,12623,12624,12625,12626,12627,12628,],
//            '125' => [12501,12502,12503,12504,12505,12506,12507,12508,12509,12510,12511,12512,12513,12514,12515,12516,12517,12518,12519,12520,12521,12522,12523,12524,12525,12526,],
//            '124' => [12401,12402,12403,12404,12405,12406,12407,12408,12409,12410,12411,12412,12413,12414,12415,12416,12417,12418,12419,12420,12421,12422,12423,12424,12425,],
            // 123 => [12301,12302,12303,12304,12305,12306,12307,12308,12309,12310,12311,12312,12313,12314,12315,12316,12317,12318,12319,12320,12321,12322,12323,12324,12325,],
            // 122 => [12201,12202,12203,12204,12205,12206,12207,12208,12209,12210,12211,12212,12213,12214,12215,12216,12217,12218,12219,12220,12221,12222,12223,12224,12225,12226,12227,],
            // 121 => [12101,12102,12103,12104,12105,12106,12107,12108,12109,12110,12111,12112,12113,12114,12115,12116,12117,12118,12119,12120,12121,12122,12123,12124,12125,12126,12127,],
            // 120 => [12001,12002,12003,12004,12005,12006,12007,12008,12009,12010,12011,12012,12013,12014,12015,12016,12017,12018,12019,12020,12021,12022,12023,12024,12025,12026,12027,12028,],
            // 119 => [11901,11902,11903,11904,11905,11906,11907,11908,11909,11910,11911,11912,11913,11914,11915,11916,11917,11918,11919,11920,11921,11922,11923,11924,11925,11926,11927,11928,],
            // 118 => [11801,11802,11803,11804,11805,11806,11807,11808,11809,11810,11811,11812,11813,11814,11815,11816,11817,11818,11819,11820,11821,11822,11823,11824,11825,11826,],
            // 117 => [11701,11702,11703,11704,11705,11706,11707,11708,11709,11710,11711,11712,11713,11714,11715,11716,11717,11718,11719,11720,11721,11722,11723,11724,11725,11726,11727,],
            // 116 => [11601,11602,11603,11604,11605,11606,11607,11608,11609,11610,11611,11612,11613,11614,11615,11616,11617,11618,11619,11620,11621,11622,11623,11624,11625,11626,11627,],
            // 115 => [11501,11502,11503,11504,11505,11506,11507,11508,11509,11510,11511,11512,11513,11514,11515,11516,11517,11518,11519,11520,11521,11522,11523,11524,11525,11526,11527,],
            // 114 => [11401,11402,11403,11404,11405,11406,11407,11408,11409,11410,11411,11412,11413,11414,11415,11416,11417,11418,11419,11420,11421,11422,11423,11424,11425,11426,11427,],
            // 113 => [11301,11302,11303,11304,11305,11306,11307,11308,11309,11310,11311,11312,11313,11314,11315,11316,11317,11318,11319,11320,11321,11322,11323,11324,11325,11326,11327,],
            // 112 => [11201,11202,11203,11204,11205,11206,11207,11208,11209,11210,11211,11212,11213,11214,11215,11216,11217,11218,11219,11220,11221,11222,11223,11224,11225,11226],
            110 => [11101,11102,11103,11104,11105,11106,11107,11108,11109,11110,11111,11112,11113,11114,11115,11116,11117,11118,11119,11120,11121,11122,11123,11124,11125,11126],
            // 109 => [10901,10902,10903,10904,10905,10906,10907,10908,10909,10910,10911,10912,10913,10914,10915,10916,10917,10918,10919,10920,10921,10922,10923,10924,10925,10926,10927,],
        ];

        $arrMonsterID = [];
        $arrTeam = $this->convertXMLToArrPHP('team.xml');
        for ($i = 0; $i < count($arrTeam['team']); $i++) {
            $arrMonsterID[$arrTeam['team'][$i]['@attributes']['id']] = $this->convertStringToArray($arrTeam['team'][$i]['@attributes']['monsterID']);
        }

        // convert XML to PHP


        $phpDataArray = $this->convertXMLToArrPHP('copyNeedConf_71_140.xml');
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
