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
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\ImageFactory;
use Spatie\MediaLibrary\Support\TemporaryDirectory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Filesystem;

class Post extends Model implements HasMedia
{
    use SoftDeletes, HasTranslations, InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'media_paths' => 'array',
    ];

    public $translatable = [
        'title',
        'description',
        'location',
    ];

    public static $mediaCollection = 'posts'; 

    public function registerMediaConversions(?Media $media = null): void
    {
        if (!$media) {
            return;
        }
        if ($media->getTypeFromMime() == 'image') {
            $width = $media->custom_properties['width'] ?? null;
            $height = $media->custom_properties['height'] ?? null;

            // Get "width" and "height"
            if (!$width || !$height) {
                $temporaryDirectory = TemporaryDirectory::create();
                $baseImage = app(Filesystem::class)->copyFromMediaLibrary(
                    $media,
                    $temporaryDirectory->path(Str::random(16) . '.' . $media->extension)
                );
                $image = ImageFactory::load($baseImage);
                
                $width = $image->getWidth();
                $height = $image->getHeight();

                $media->setCustomProperty('width', $width);
                $media->setCustomProperty('height', $height);
                $media->save();
            }

            $thumb_width = 400;
            $sm_min_width = 400;
            $md_min_width = 600;
            $lg_min_width = 800;

            // // Thumbnail: Fixed width, maintain aspect ratio
            $this->addMediaConversion('thumb')
                ->width($thumb_width);

            // Small: 25% of original size
            if ($width > $sm_min_width) {
                $this->addMediaConversion('sm')
                    ->fit(Fit::Crop, (int)($width * 0.25), (int)($height * 0.25));
            }

            // Medium: 50% of original size
            if ($width > $md_min_width) {
                $this->addMediaConversion('md')
                    ->fit(Fit::Crop, (int)($width * 0.5), (int)($height * 0.5));
            }

            // Large: 75% of original size
            if ($width > $lg_min_width) {
                $this->addMediaConversion('lg')
                    ->fit(Fit::Crop, (int)($width * 0.75), (int)($height * 0.75));
            }
        }
    }

    public function shouldDeletePreservingMedia(): bool
    {
        return true;
    }

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

}
