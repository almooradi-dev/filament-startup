<?php

namespace App\Models\Stock;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        'description'
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
}
