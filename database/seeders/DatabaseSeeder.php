<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('master_category')->insert([
            ['name'=>'Elektronik','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Alat Tulis Kantor','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Furnitur','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Kebersihan','created_at'=>now(),'updated_at'=>now()],
        ]);

        DB::table('master_unit')->insert([
            ['name'=>'Pcs','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Buah','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Set','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Rim','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Botol','created_at'=>now(),'updated_at'=>now()],
        ]);

        DB::table('users')->insert([
            ['name'=>'Super Admin','email'=>'admin@kantor.com','password'=>Hash::make('admin123'),'role'=>'superadmin','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Agustine','email'=>'operator@kantor.com','password'=>Hash::make('op123'),'role'=>'operator','created_at'=>now(),'updated_at'=>now()],
        ]);

        DB::table('master_items')->insert([
            ['code'=>'ITM-001','name'=>'Laptop Dell Latitude','category_id'=>1,'unit_id'=>1,'stock'=>8,'min_stock'=>3,'location'=>'Ruang IT','status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['code'=>'ITM-002','name'=>'Printer HP LaserJet','category_id'=>1,'unit_id'=>1,'stock'=>2,'min_stock'=>2,'location'=>'Ruang Admin','status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['code'=>'ITM-003','name'=>'Kertas A4 80gsm','category_id'=>2,'unit_id'=>4,'stock'=>15,'min_stock'=>10,'location'=>'Gudang','status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['code'=>'ITM-004','name'=>'Pulpen Pilot G2','category_id'=>2,'unit_id'=>1,'stock'=>3,'min_stock'=>20,'location'=>'Gudang','status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['code'=>'ITM-005','name'=>'Kursi Kantor','category_id'=>3,'unit_id'=>2,'stock'=>12,'min_stock'=>5,'location'=>'Gudang Furnitur','status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['code'=>'ITM-006','name'=>'Sabun Cuci Tangan','category_id'=>4,'unit_id'=>5,'stock'=>1,'min_stock'=>5,'location'=>'Pantry','status'=>'active','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}