<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Hardware', 'description' => 'Issues related to computer hardware', 'color' => '#007bff'],
            ['name' => 'Software', 'description' => 'Software installation and problems', 'color' => '#28a745'],
            ['name' => 'Network', 'description' => 'Network connectivity issues', 'color' => '#6f42c1'],
            ['name' => 'Email', 'description' => 'Email client and server issues', 'color' => '#fd7e14'],
            ['name' => 'Account', 'description' => 'User account and access problems', 'color' => '#20c997'],
            ['name' => 'Other', 'description' => 'Other types of issues', 'color' => '#6c757d'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
