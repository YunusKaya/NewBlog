<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count=0;
        $pages=['Hakkımızda','Kariyer','Vizyon','Misyon'];
        foreach ($pages as $page)
        {
            $count++;
            $faker=Faker::create();
            DB::table('pages')->insert([
                'title'=>$page,
                'img'=>'https://assets.entrepreneur.com/content/3x2/2000/20160602195129-businessman-writing-planning-working-strategy-office-focus-formal-workplace-message.jpeg',
                'content'=>'Lorem ipsum dolor sit amet, consectetur
                            adipisicing elit. Eos hic nihil optio sit
                            tenetur! Dolor excepturi, inventore labore
                            laborum nam placeat porro quasi repellat
                            sequi soluta? Dolorem nesciunt nisi nulla!',
                'slug'=>Str::slug($page),
                'order'=>$count
            ]);
        }
    }
}
