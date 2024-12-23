<?php

namespace App\Models\Stock;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use SoftDeletes, HasTranslations;

    protected $guarded = [];

    protected $casts = [
        'media' => 'array',
    ];

    public $translatable = [
        'title',
        'description',
        'location',
    ];

    /**
     * Scope where status
     *
     * @param Builder $query
     * @return void
     */
    public function scopeWhereStaus(Builder $query, string $key)
    {
        $query->whereHas('status', fn($query) => $query->where('key', 'active'));
    }

    /**
     * Get post's status
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(PostStatus::class, 'status_id');
    }

    /**
     * Get post's author
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get post's type
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(PostType::class, 'type_id');
    }

    /**
     * Get post's collections
     *
     * @return BelongsToMany
     */
    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(PostCollection::class, 'posts_collections_pivot', 'post_id', 'collection_id');
    }

    /**
     * Get post's tags
     *
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(PostTag::class, 'posts_tags_pivot', 'post_id', 'tag_id');
    }

    /**
     * Get "media_url" attribute
     *
     * @return string|null
     */
    public function getMediaUrlAttribute(): ?string
    {
        if (count($this->media) > 0) {
            return Storage::disk('s3')->url($this->media[0]);
        }

        return null;
    }

    /**
     * Get "thumbnail_url" attribute
     *
     * @return ?string
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if (count($this->media) == 0 || $this->type->key == 'video') {
            return null;
        }

        // Get the original image path from your model attribute
        $originalImagePath = $this->media[0];

        // Generate the thumbnail path by appending '-thumbnail' before the extension
        $thumbnailPath = pathinfo($originalImagePath, PATHINFO_DIRNAME) . '/' .
            pathinfo($originalImagePath, PATHINFO_FILENAME) . '-thumbnail.' . pathinfo($originalImagePath, PATHINFO_EXTENSION);

        // Check if the thumbnail exists in S3
        if (Storage::disk('s3')->exists($thumbnailPath)) {
            // Return the URL of the existing thumbnail
            return Storage::disk('s3')->url($thumbnailPath);
        }

        // If thumbnail does not exist, create and upload it
        $image = ImageManager::imagick()->read(Storage::disk('s3')->get($originalImagePath));

        $width = 400; // px
        $image->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize(); // Prevent upsizing the image if it's smaller than 100px
        });

        // Save the thumbnail to S3
        $thumbnailContents = (string) $image->encode(); // Get the image as a string

        // Upload the thumbnail to S3
        Storage::disk('s3')->put($thumbnailPath, $thumbnailContents);

        // Return the URL of the uploaded thumbnail
        return Storage::disk('s3')->url($thumbnailPath);
    }
}
