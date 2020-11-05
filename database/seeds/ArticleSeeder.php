<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<=10;$i++)
        {
            $faker=Faker::create();
            $title=$faker->sentence(6);

            DB::table('articles')->insert([
                'catagoryID'=>rand(1,7),
                'title'=>$title,
                'image'=>$faker->imageUrl('800', '400', 'cats', true, 'blagsitesi'),
                'content'=>$faker->realText(300),
                'hit'=>0,
                'status'=>0,
                'slug'=>Str::slug($title)
            ]);
        }
    }
}
