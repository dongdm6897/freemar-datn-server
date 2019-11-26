<?php


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PaymentTypeTableSeeder::class,
            HelpLinkTableSeeder::class,
            MasterOrderStatusTableSeeder::class,
            MasterPaymentMethodTableSeeder::class,
            MasterNotificationTypeTableSeeder::class,
            TagTableSeeder::class,
            ShippingStatusTableSeeder::class,
            AttributeTypeTableSeeder::class,
            AttributeTableSeeder::class,
            MasterCollectionTableSeeder::class,
            MasterIdentifyPhotoTypeSeeder::class,
            MasterShipProviderTableSeeder::class,
            MasterTargetGenderTableSeeder::class,
            MasterUserStatusTableSeeder::class,
            MasterAssessmentTypeTableSeeder::class,
            MasterDetailAssessmentTypeTableSeeder::class,
            MasterCommerceFeeTableSeeder::class,
            BrandTableSeeder::class,
            CategoryTableSeeder::class,
            UserTableSeeder::class,
            MasterProductStatusTableSeeder::class,
            ShipPayMethodTableSeeder::class,
            ShipTimeEstimationTableSeeder::class,
            ProductTableSeeder::class,
            MessageTableSeeder::class,
            ProductCommentTableSeeder::class,
            MasterCollectionTableSeeder::class,
            WatchedProductTableSeeder::class,
            CategoryAttributeTypeTableSeeder::class,
            ProviderServiceSeeder::class,
            MasterDetailAssessmentTypeTableSeeder::class,
            MasterBankTypeTableSeeder::class,
            MasterBankTableSeeder::class,
            PermissionTableSeeder::class,
            RolesAndPermissionsSeeder::class,
            AdsTypeTableSeeder::class,
            AdsTableSeeder::class
        ]);
    }
}
