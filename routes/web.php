<?php

use App\Models\Stock\Post;
use App\Models\Stock\PostCollection;
use App\Models\Stock\PostTag;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('filament.admin.pages.dashboard');
});


Route::get('dev-only/import-wp', function () {
    set_time_limit(500);

    $filePath = '/home/ahmant/Downloads/ulz_listings.json';
    $jsonData = file_get_contents($filePath);
    $data = json_decode($jsonData, true);

    // dd($data);

    try {
        DB::beginTransaction();
        $lastRow = null;
        foreach ($data as $row) {
            $lastRow = $row;

            // Author
            $author = User::firstOrCreate(
                ['username' => $row['user_username']],
                [
                    'first_name' => $row['user_display_name'],
                    'password' => Hash::make($row['user_username'] . '@123')
                ]
            );

            // Post
            $post = Post::create([
                'title' => $row['title'],
                'slug' => $row['slug'],
                'description'   => $row['description'],
                'location' => $row['location_name'],
                'location_lat'  => $row['location_lat'],
                'location_lng'  => $row['location_lng'],

                'author_id' => $author->id,
                'status_id' => $row['status_key'] == 'published' ? 1 : 0,
                'type_id'   => $row['video_path'] ? 2 : 1,

                'media' => [
                    $row['image_path'] ?? $row['video_path']
                ],

                'created_at' => "2024-10-09 18:04:58",
                'updated_at' => "2024-10-09 18:04:58"
            ]);

            // Sync Collections
            if (!empty($row['collections_ids'])) {
                $post->collections()->sync($row['collections_ids']);
            }

            // Sync Tags
            if (!empty($row['tags_ids'])) {
                $post->tags()->sync($row['tags_ids']);
            }
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();

        dd($e, $lastRow);
    }
});
