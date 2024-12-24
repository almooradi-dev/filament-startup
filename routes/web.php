<?php

use App\Models\Stock\Post;
use App\Models\Stock\PostCollection;
use App\Models\Stock\PostTag;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return redirect()->route('filament.admin.pages.dashboard');
});




/**
 * ------------------------------------------------------
 */
Route::get('dev-only/test', function () {
    // $oldDirectory = 'posts';
    // $newDirectory = 'posts_to_be_deleted';

    // Storage::disk('s3')->deleteDirectory($oldDirectory);
    
    // // $disk = Storage::disk('s3');
    
    // // // Get all files in the old directory
    // // $files = $disk->files($oldDirectory);

    // // foreach ($files as $file) {
    // //     // Determine the new file path in the new directory
    // //     $newFilePath = $newDirectory . '/' . basename($file);

    // //     // Copy the file to the new location
    // //     $disk->copy($file, $newFilePath);

    // //     // Delete the old file
    // //     // $disk->delete($file);
    // // }
});

// Route::get('dev-only/import-wp', function () {
//     set_time_limit(500);

//     $files = Storage::disk('s3')->allFiles();
//     dd($files);

//     $filePath = '/home/ahmant/Downloads/ulz_listings.json';
//     $jsonData = file_get_contents($filePath);
//     $data = json_decode($jsonData, true);

//     try {
//         DB::beginTransaction();
//         $lastRow = null;
//         // foreach ($data as $row) {
//         foreach (array_slice($data, 0, 500) as $row) {
//             $lastRow = $row;

//             // Author
//             $author = User::firstOrCreate(
//                 ['username' => $row['user_username']],
//                 [
//                     'first_name' => $row['user_display_name'],
//                     'password' => Hash::make($row['user_username'] . '@123')
//                 ]
//             );

//             // Post
//             $post = Post::create([
//                 'title' => $row['title'],
//                 'slug' => $row['slug'],
//                 'description'   => $row['description'],
//                 'location' => $row['location_name'],
//                 'location_lat'  => $row['location_lat'],
//                 'location_lng'  => $row['location_lng'],

//                 'author_id' => $author->id,
//                 'status_id' => $row['status_key'] == 'published' ? 1 : 0,
//                 'type_id'   => $row['video_path'] ? 2 : 1,

//                 // 'media' => [
//                 //     // $row['image_path'] ?? $row['video_path']
//                 // ],

//                 'created_at' => "2024-10-09 18:04:58",
//                 'updated_at' => "2024-10-09 18:04:58"
//             ]);

//             // Media (Download from S3 then re-upload)
//             $mediaPath = $row['image_path'] ?? $row['video_path'];
//             if (!Storage::disk('s3')->exists($mediaPath)) {
//                 $mediaPath = $mediaPath ? pathinfo($mediaPath, PATHINFO_DIRNAME) . '/' .
//                     pathinfo($mediaPath, PATHINFO_FILENAME) . '-scaled.' . pathinfo($mediaPath, PATHINFO_EXTENSION) : null;
//             }
//             if (Storage::disk('s3')->exists($mediaPath)) {
//                 $fileName = basename($mediaPath);
//                 $mediaURL = Storage::disk('s3')->url($mediaPath);
//                 $fileContent = file_get_contents($mediaURL);  // Assuming $mediaPath is the URL

//                 // Create a temporary file to store the file content
//                 $tempFilePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileName;
//                 file_put_contents($tempFilePath, $fileContent);

//                 // Upload the file to the 'posts' media collection on S3
//                 $post->addMedia($tempFilePath)
//                     ->toMediaCollection(Post::$mediaCollection, 's3');

//                 // Clean up the temporary file after upload
//                 // unlink($tempFilePath);
//             } else {
//                 echo 'No media for post "' . $post->id . '"';
//                 echo '<br>';
//             }

//             // Sync Collections
//             if (!empty($row['collections_ids'])) {
//                 $post->collections()->sync($row['collections_ids']);
//             }

//             // Sync Tags
//             if (!empty($row['tags_ids'])) {
//                 $post->tags()->sync($row['tags_ids']);
//             }
//         }

//         DB::commit();
//     } catch (\Exception $e) {
//         DB::rollBack();

//         dd($e, $lastRow);
//     }
// });
