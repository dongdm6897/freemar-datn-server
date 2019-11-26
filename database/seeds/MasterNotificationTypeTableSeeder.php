<?php

use Illuminate\Database\Seeder;
use App\Enums\NotificationTypeEnum;

class MasterNotificationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('master_notification_type')->truncate();
        $notification_id = NotificationTypeEnum::getValues();
        foreach ($notification_id as $value) {
            DB::table('master_notification_type')->insert([
                'id' =>$value,
                'name' => NotificationTypeEnum::getKey($value),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
