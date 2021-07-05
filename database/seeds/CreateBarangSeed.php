<?php

use Illuminate\Database\Seeder;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class CreateBarangSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Barang::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(Barang::class, 10)->create();
    }
}
