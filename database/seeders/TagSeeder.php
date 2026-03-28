<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Tag::create(['name' => 'Workshop']);
        \App\Models\Tag::create(['name' => 'Seminar']);
        \App\Models\Tag::create(['name' => 'Competition']);
        \App\Models\Tag::create(['name' => 'Volunteer']);
        \App\Models\Tag::create(['name' => 'Exhibition']);
        \App\Models\Tag::create(['name' => 'Concert']);
        \App\Models\Tag::create(['name' => 'Sports']);
        \App\Models\Tag::create(['name' => 'Activity Transcript']);
        \App\Models\Tag::create(['name' => 'ชั่วโมงจิตอาสา']);
        \App\Models\Tag::create(['name' => 'Certificate']);
        \App\Models\Tag::create(['name' => 'Free Food']);
        \App\Models\Tag::create(['name' => 'Free Entry']);
        \App\Models\Tag::create(['name' => 'Freshy Only']);
        \App\Models\Tag::create(['name' => 'Open to All']);
        \App\Models\Tag::create(['name' => 'Alumni']);
        \App\Models\Tag::create(['name' => 'Tech & Innovation']);
        \App\Models\Tag::create(['name' => 'Business & Startup']);
        \App\Models\Tag::create(['name' => 'Art & Design']);
        \App\Models\Tag::create(['name' => 'Soft Skills']);
        \App\Models\Tag::create(['name' => 'Language']);
    }
}
