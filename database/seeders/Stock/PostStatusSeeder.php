<?php

namespace Database\Seeders\Stock;

use App\Models\Core\UserStatus;
use App\Models\Stock\PostCollection;
use App\Models\Stock\PostStatus;
use App\Models\Stock\PostTag;
use App\Models\Stock\PostType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'key' => 'published',
                'name' => [
                    'en' => 'Published',
                    'ar' => 'تم النشر'
                ],
                'color' => '#2ecc71'
            ],
            [
                'key' => 'pending_review',
                'name' => [
                    'en' => 'Pending Review',
                    'ar' => 'قيد المراجعة'
                ],
                'color' => '#f1c40f'
            ],
            [
                'key' => 'rejected',
                'name' => [
                    'en' => 'Rejected',
                    'ar' => 'مرفوض'
                ],
                'color' => '#e74c3c'
            ],
        ];

        foreach ($statuses as $status) {
            PostStatus::updateOrCreate(
                ['key' => $status['key']],
                [
                    'name' => $status['name'],
                    'color' => $status['color'],
                    'is_active' => 1
                ]
            );
        }
    }
}
