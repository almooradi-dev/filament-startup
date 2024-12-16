<?php

namespace Database\Seeders\Stock;

use App\Models\Core\UserStatus;
use App\Models\Stock\PostCollection;
use App\Models\Stock\PostTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'key' => 'accessories',
                'name' => [
                    'en' => 'Accessories',
                    'ar' => 'إكسسوارات'
                ],
            ],
            [
                'key' => 'art',
                'name' => [
                    'en' => 'Art',
                    'ar' => 'فن'
                ],
            ],
            [
                'key' => 'fashion',
                'name' => [
                    'en' => 'Fashion',
                    'ar' => 'موضة'
                ],
            ],
            [
                'key' => 'life',
                'name' => [
                    'en' => 'Life',
                    'ar' => 'الحياة'
                ],
            ],
            [
                'key' => 'nikon',
                'name' => [
                    'en' => 'Nikon',
                    'ar' => 'Nikon'
                ],
            ],
            [
                'key' => 'outdoor',
                'name' => [
                    'en' => 'Outdoor',
                    'ar' => 'الخارج'
                ],
            ],
            [
                'key' => 'portrait',
                'name' => [
                    'en' => 'Portrait',
                    'ar' => 'صورة للوجه'
                ],
            ],
            [
                'key' => 'smile',
                'name' => [
                    'en' => 'Smile',
                    'ar' => 'إبتسامة'
                ],
            ],
            [
                'key' => 'sunset',
                'name' => [
                    'en' => 'Sunset',
                    'ar' => 'غروب الشمس'
                ],
            ],
        ];

        foreach ($tags as $tag) {
            PostTag::updateOrCreate(
                ['key' => $tag['key']],
                [
                    'name' => $tag['name'],
                    'is_active' => 1
                ]
            );
        }
    }
}
