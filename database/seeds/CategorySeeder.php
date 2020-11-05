<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $catago=['Eğlence','Bilişim','Gezi','Teknoloji','Sağlık','Spor','Günlük Yaşam'];
        foreach ($catago as $cata)
        {
            DB::table('categories')->insert([
               'name'=>$cata,
                'slug'=>Str::slug($cata)
            ]);
        }
    }
}
