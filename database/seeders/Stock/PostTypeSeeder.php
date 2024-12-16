<?php

namespace Database\Seeders\Stock;

use App\Models\Core\UserStatus;
use App\Models\Stock\PostCollection;
use App\Models\Stock\PostTag;
use App\Models\Stock\PostType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'key' => 'photo',
                'name' => [
                    'en' => 'Photo',
                    'ar' => 'صورة'
                ],
            ],
            [
                'key' => 'video',
                'name' => [
                    'en' => 'Video',
                    'ar' => 'فيديو'
                ],
            ],
            [
                'key' => 'vector',
                'name' => [
                    'en' => 'Vector',
                    'ar' => 'Vector'
                ],
            ],
        ];

        foreach ($types as $type) {
            PostType::updateOrCreate(
                ['key' => $type['key']],
                [
                    'name' => $type['name'],
                    'is_active' => 1
                ]
            );
        }
    }
}
