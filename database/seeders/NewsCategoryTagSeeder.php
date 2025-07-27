<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use App\Models\News;

class NewsCategoryTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Nieuws', 'slug' => 'nieuws', 'color' => '#3498db'],
            ['name' => 'Evenementen', 'slug' => 'evenementen', 'color' => '#2ecc71'],
            ['name' => 'Aankondigingen', 'slug' => 'aankondigingen', 'color' => '#e74c3c'],
            ['name' => 'Interviews', 'slug' => 'interviews', 'color' => '#9b59b6'],
            ['name' => 'Verhalen', 'slug' => 'verhalen', 'color' => '#f39c12'],
        ];

        foreach ($categories as $category) {
            NewsCategory::create($category);
        }

        // Create tags
        $tags = [
            ['name' => 'Volt FM', 'slug' => 'volt-fm'],
            ['name' => 'Radio', 'slug' => 'radio'],
            ['name' => 'Muziek', 'slug' => 'muziek'],
            ['name' => 'Podcast', 'slug' => 'podcast'],
            ['name' => 'Cultuur', 'slug' => 'cultuur'],
            ['name' => 'Technologie', 'slug' => 'technologie'],
            ['name' => 'Sport', 'slug' => 'sport'],
            ['name' => 'Entertainment', 'slug' => 'entertainment'],
        ];

        foreach ($tags as $tag) {
            NewsTag::create($tag);
        }

        // Assign categories and tags to existing news articles
        $news = News::all();
        $categoryIds = NewsCategory::pluck('id')->toArray();
        $tagIds = NewsTag::pluck('id')->toArray();
        
        foreach ($news as $article) {
            // Assign a random category
            $article->category_id = $categoryIds[array_rand($categoryIds)];
            $article->save();
            
            // Assign random tags (1-3 tags per article)
            $randomTagCount = rand(1, 3);
            $selectedTags = array_rand(array_flip($tagIds), $randomTagCount);
            
            if (!is_array($selectedTags)) {
                $selectedTags = [$selectedTags];
            }
            
            $article->tags()->attach($selectedTags);
        }
    }
}
