<?php

namespace Database\Seeders;

use App\Models\Report;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $reports = Report::all();

        $reports->each(function ($report)
        {
            $report->image()->create(['path' => "https://picsum.photos/id/$report->id/200/300"]);
        });


    }
}
