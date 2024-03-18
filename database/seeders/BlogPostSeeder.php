<?php

namespace GrassFeria\StarterkidBlog\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \GrassFeria\StarterkidBlog\Models\BlogPost::create([
            'id'                                        => 1,
            
        ]);
    }
}