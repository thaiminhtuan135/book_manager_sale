<?php

namespace Database\Seeders;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        $category = [
//            'Khoa học viễn tưởng',
//            'Tình cảm',
//            'Dạy làm giàu',
//            'Quản trị',
//            'Kinh tế',
//            'Kỹ năng sống',
//            'Chính trị - pháp luật',
//            'Khoa học công nghệ',
//            'Tâm linh',
//            'Truyền cảm hứng'
//        ];
//        $image=[
//            '/imgBook/3d2731bd3495a3a3b4abce1ba2ada02e.jpg',
//            '/imgBook/38cec20c7e5d848f1d149e2f6bdc711d1c95f2649.png',
//            '/imgBook/08de03b47ec07fb8548fb0b695c718618b0f6824.png',
//            '/imgBook/4290c1e59ec75153fe85120d53d7a413b549b4d4.jpg',
//            '/imgBook/350577c42a783441a8a69226c9cb1db74a78033b.jpg',
//            '/imgBook/704089ee55cf911e735b4f4562569c21ce4cc8db.jpg',
//            '/imgBook/709097a62475a3bd396dd876306ae7f088c6fea9.png',
//            '/imgBook/b7c89d25cfacc56cdf700ade8fe3f5366106ea3d.jpg',
//            '/imgBook/bia1s.png',
//            '/imgBook/Bí-mật-tư-duy-triệu-phú-sách-dạy-làm-giàu-compressor.jpg',
//            '/imgBook/cuon-sach-hay-ve-ky-nang-song-dac-nhan-tam.jpg',
//            '/imgBook/Hành-trình-về-phương-đông.jpg',
//            '/imgBook/huan-hoa-hong-15879586607891232678525.jpg',
//            '/imgBook/image_241801.jpg',
//            '/imgBook/img181_2_5.jpg',
//            '/imgBook/kham-pha-the-gioi-tam-linh.png',
//            '/imgBook/Kinh-te-1.jpg',
//            '/imgBook/kinh-te-hoc-vi-mo-1616404088_1__3e4955887b2d408abfade01fb87f807f.webp',
//            '/imgBook/kinh-te-hoc-vi-mo-1616404088_1__3e4955887b2d408abfade01fb87f807f (1).jpg',
//            '/imgBook/lMJgYgdUlarge.jpg',
//            '/imgBook/loi-thu-toi-moi-cua-mot-sat-thu-kinh-te-761353.jpg',
//            '/imgBook/quan_ly_rui_ro_kinh_doanh_38352da773.jpg',
//            '/imgBook/quantrihocpng.png',
//            '/imgBook/sach-cach-nen-kinh-te-van-hanh.jpg',
//            '/imgBook/sach-kheo-an-noi-se-co-duoc-thien-ha-209x300.jpg',
//            '/imgBook/Sach-phap-luat-dai-cuong-dung-trong-cac-truong-dai-hoc-cao-dang-trung-cap.jpg',
//            '/imgBook/sach-thanh-pho-thong-minh-nen-tang-nguyen-ly-203x300.png',
//            '/imgBook/scan00351.jpg',
//            '/imgBook/tải xuống.jpg',
//            '/imgBook/u10836_t1409798085_8GcK8.jpg',
//            '/imgBook/upload_2021-8-4_21-15-37.png',
//        ];
//        dd($image);
//        DB::table('book')->truncate();
//        for ($i = 0; $i < 100; $i++) {
//            DB::table('book')->insert([
//                'title' => Str::random(10),
//                'author' => Str::random(10),
//                'category' =>$category[rand(0,9)],
//                'release_date' => Carbon::today()->subDays(rand(0, 700))->format('Y-m-d H:i:s'),
//                'number_page' => rand(100,1000),
//                'image' => $image[rand(0, 29)],
//            ]);
//        }

        DB::table('book')->truncate();
        Book::factory(200)->create();
    }
}
