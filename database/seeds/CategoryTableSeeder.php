<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('category')->truncate();

        $category_father = [
            "Điện Thoại - Máy Tính Bảng"=>"cellphone",
            "Điện Tử - Điện Lạnh"=>"cellphone",
            "Phụ Kiện - Thiết Bị Số"=>"headphones",
            "Laptop - Thiết Bị IT"=>"cellphone",
            "Máy Ảnh - Quay Phim"=>"cellphone",
            "Điện Gia Dụng"=>"cellphone ",
            "Nhà Cửa - Đời Sống"=>"cellphone",
            "Hàng Tiêu Dùng - Thực phẩm"=>"cellphone ",
            "Đồ Chơi, Mẹ & Bé"=>"cellphone ",
            "Làm Đẹp - Sức khỏe"=>"cellphone",
            "Thời Trang - Phụ Kiện"=>"cellphone ",
            "Thể Thao - Dã Ngoại"=>"cellphone ",
            "Xe Máy, Ô tô, Xe Đạp"=>"cellphone",
            "Sách, VPP & Quà Tặng"=>"cellphone",
            "Khác"=>""];
        $category_son_1 = [
            "Máy tính bảng"=>"cellphone ",
            "Máy đọc sách"=>"cellphone ",
            "Điện thoại phổ thông"=>"cellphone ",
            "Điện thoại bàn"=>"cellphone ",];
        $category_son_2 = [
            "Tivi"=>"cellphone ",
            "Âm thanh & phụ kiện Tivi"=>"cellphone",
            "Máy giặt"=>"cellphone",
            "Máy sấy quần áo"=>"cellphone",
            "Máy rửa chén"=>"",
            "Máy lạnh - Máy điều hòa"=>"",
            "Tủ lạnh"=>"",
            "Tủ đông - Tủ mát"=>"",
            "Tủ ướp rượu"=>""];
        $category_son_3 = [
            "Thiết bị âm thanh và phụ kiện"=>"cellphone ",
            "Thiết bị chơi game và phụ kiên"=>"",
            "Thiết bị đeo thông minh và phụ kiện"=>"",
            "Thiết bị thông minh và linh kiện điện tử"=>"",
            "Phụ kiện điện thoại và máy tính bảng"=>"",
            "Phụ kiện máy tính và Laptop"=>"" ];
        foreach ($category_father as $key => $value)
        {
            \Illuminate\Support\Facades\DB::table('category')->insert([
                'name' => $key,
                'icon' => $value,
                'description' => "Let me up fast",

            ]);
        }
        foreach ($category_son_1 as $key => $value)
        {
            \Illuminate\Support\Facades\DB::table('category')->insert([
                'name' => $key,
                'icon' => $value,
                'description' => "Let me up fast",
                'parent_id' => 1

            ]);
        }
        foreach ($category_son_2 as $key => $value)
        {
            \Illuminate\Support\Facades\DB::table('category')->insert([
                'name' => $key,
                'icon' => $value,
                'description' => "Let me up fast",
                'parent_id' => 2

            ]);
        }
        foreach ($category_son_3 as $key => $value)
        {
            \Illuminate\Support\Facades\DB::table('category')->insert([
                'name' => $key,
                'icon' => $value,
                'description' => "Let me up fast",
                'parent_id' => 3

            ]);
        }

        factory(App\Models\Category::class, 30)->create();

        Schema::enableForeignKeyConstraints();
    }
}
