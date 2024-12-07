<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use SoftDeletes, HasTranslations;

    protected $guarded = [];

    public $translatable = [
        'title', 'description'
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
}
