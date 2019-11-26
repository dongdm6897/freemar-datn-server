<?php

use App\Enums\UserStatusEnum;
use Illuminate\Database\Seeder;

class MasterUserStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('products')->truncate();
        $user_status_ids = UserStatusEnum::getValues();
        foreach ($user_status_ids as $value) {
            DB::table('master_user_status')->insert([
                'id' => $value,
                'name' => UserStatusEnum::getKey($value),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
