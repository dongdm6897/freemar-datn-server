<?php

use Illuminate\Database\Seeder;

class HelpLinkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('help_link')->truncate();
        $names = [
            'help1',
            'help2',
            'help3',
            'help4',
            'help5',
            'feedback',
        ];
        $links = [
            'https://baibai554889985.wordpress.com/gioi-thieu-ve-baibai-vn/',
            'https://baibai554889985.wordpress.com/cach-dang-ban-san-pham-tren-baibai/',
            'https://baibai554889985.wordpress.com/quy-trinh-giao-dich-an-toan-tren-baibai-vn/',
            'https://baibai554889985.wordpress.com/hieu-ve-cac-chi-phi-khi-mua-ban-hang-tren-baibai-vn/',
            'https://baibai554889985.wordpress.com/quy-dinh-ve-danh-muc-va-san-pham-duoc-phep-dang-ban/',
            'https://goo.gl/forms/jz3iPSACUPlAmqnF2'
        ];
        foreach ($names as $key => $value) {
            DB::table('help_link')->insert([
                'name' => $value,
                'link' => $links[$key],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
