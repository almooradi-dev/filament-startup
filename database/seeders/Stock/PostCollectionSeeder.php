<?php

namespace Database\Seeders\Stock;

use App\Models\Core\UserStatus;
use App\Models\Stock\PostCollection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = [
            [
                'key' => 'wallpaper',
                'name' => [
                    'en' => 'Wallpaper',
                    'ar' => 'خلفيات الشاشة'
                ],
            ],
            [
                'key' => 'health_wellness',
                'name' => [
                    'en' => 'Health & Wellness',
                    'ar' => 'الصحة والعافية'
                ],
            ],
            [
                'key' => 'business_work',
                'name' => [
                    'en' => 'Business & Work',
                    'ar' => 'الإدارة والعمل'
                ],
            ],
            [
                'key' => 'textures_patterns',
                'name' => [
                    'en' => 'Textures & Patterns',
                    'ar' => 'القوام والأنماط'
                ],
            ],
            [
                'key' => 'food',
                'name' => [
                    'en' => 'Food',
                    'ar' => 'الطعام'
                ],
            ],
            [
                'key' => 'summer',
                'name' => [
                    'en' => 'Summer',
                    'ar' => 'الصيف'
                ],
            ],
            [
                'key' => 'architecture_nteriors',
                'name' => [
                    'en' => 'Architecture & Interiors',
                    'ar' => 'الهندسة المعمارية والديكورات الداخلية'
                ],
            ],
            [
                'key' => 'street_photography',
                'name' => [
                    'en' => 'Street photography',
                    'ar' => 'تصوير الشوارع'
                ],
            ],
            [
                'key' => 'cars',
                'name' => [
                    'en' => 'Cars',
                    'ar' => 'السيارات'
                ],
            ],
            [
                'key' => 'animal',
                'name' => [
                    'en' => 'Animal',
                    'ar' => 'الحيوانات'
                ],
            ],
            [
                'key' => 'nature_travel',
                'name' => [
                    'en' => 'Nature & Travel',
                    'ar' => 'الطبيعة والسفر'
                ],
            ],
            [
                'key' => 'people',
                'name' => [
                    'en' => 'People',
                    'ar' => 'الناس'
                ],
            ],
        ];

        foreach ($collections as $collection) {
            PostCollection::updateOrCreate(
                ['key' => $collection['key']],
                [
                    'name' => $collection['name'],
                    'is_active' => 1
                ]
            );
        }
    }
}
