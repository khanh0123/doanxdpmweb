<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class GenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $result = DB::table('genre')->get();
    	if(count($result) == 0){
    		DB::table('genre')->insert([
    			[
    				'id' => 'gen001',
    				'name' => 'Hành Động',
    				'slug' => 'hanh-dong'
    			],
    			[
    				'id' => 'gen002',
    				'name' => 'Tình Cảm',
    				'slug' => 'tinh-cam'
    			],    			

    			[
    				'id' => 'gen003',
    				'name' => 'Giả tưởng',
    				'slug' => 'gia-tuong'
    			],
    			[
    				'id' => 'gen004',
    				'name' => 'Hài',
    				'slug' => 'hai'
    			],
    			[
    				'id' => 'gen005',
    				'name' => 'Phiêu lưu',
    				'slug' => 'phieu-luu'
    			],
    			[
    				'id' => 'gen006',
    				'name' => 'Kinh dị',
    				'slug' => 'kinh-di'
    			],
    			[
    				'id' => 'gen007',
    				'name' => 'Chiến tranh',
    				'slug' => 'chien-tranh'
    			],
    			[
    				'id' => 'gen008',
    				'name' => 'Tâm lý',
    				'slug' => 'tam-ly'
    			],
    			[
    				'id' => 'gen009',
    				'name' => 'Lịch sử',
    				'slug' => 'lich-su'
    			],
    			[
    				'id' => 'gen010',
    				'name' => 'Hoạt hình',
    				'slug' => 'hoat-hinh'
    			],
                [
                    'id' => 'gen011',
                    'name' => 'Hài hước',
                    'slug' => create_slug('Hài hước')
                ],
                [
                    'id' => 'gen012',
                    'name' => 'Gia đình',
                    'slug' => create_slug('Gia đình')
                ],
                [
                    'id' => 'gen013',
                    'name' => 'Viễn Tưởng',
                    'slug' => create_slug('Viễn Tưởng')
                ],
                [
                    'id' => 'gen014',
                    'name' => 'Hình sự',
                    'slug' => create_slug('Hình sự')
                ],
                [
                    'id' => 'gen015',
                    'name' => 'Khoa học',
                    'slug' => create_slug('Khoa học')
                ],
                [
                    'id' => 'gen016',
                    'name' => 'Võ thuật',
                    'slug' => create_slug('Võ thuật')
                ],
                [
                    'id' => 'gen017',
                    'name' => 'Cổ trang',
                    'slug' => create_slug('Cổ trang')
                ],
                [
                    'id' => 'gen018',
                    'name' => 'Bí Ẩn',
                    'slug' => create_slug('Bí Ẩn')
                ],
                [
                    'id' => 'gen019',
                    'name' => 'Âm Nhạc',
                    'slug' => create_slug('Âm Nhạc')
                ],
[
                    'id' => 'gen020',
                    'name' => 'Thần Thoại',
                    'slug' => create_slug('Thần Thoại')
                ],
[
                    'id' => 'gen021',
                    'name' => 'Tài liệu',
                    'slug' => create_slug('Tài liệu')
                ],
                [
                    'id' => 'gen022',
                    'name' => 'Kịch tính',
                    'slug' => create_slug('Kịch tính')
                ],
                [
                    'id' => 'gen023',
                    'name' => 'Thể thao',
                    'slug' => create_slug('Thể thao')
                ],
                [
                    'id' => 'gen024',
                    'name' => 'Tiểu sử',
                    'slug' => create_slug('Tiểu sử')
                ],
                [
                    'id' => 'gen025',
                    'name' => 'Kiếm hiệp',
                    'slug' => create_slug('Kiếm hiệp')
                ],
                [
                    'id' => 'gen026',
                    'name' => '18+',
                    'slug' => create_slug('18+')
                ],
                [
                    'id' => 'gen027',
                    'name' => 'Viễn tây',
                    'slug' => create_slug('Viễn tây')
                ],
                [
                    'id' => 'gen028',
                    'name' => 'Hài tết',
                    'slug' => create_slug('Hài tết')
                ],

    		]);

    		DB::table('max_id')->insert([
    			[
    				'table_name' => 'genre',
    				'max_id' => 'gen028'
    			],
    		]);
    	}
    }
}
