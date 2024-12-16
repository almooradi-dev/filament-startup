<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Model;

class PostTagPivot extends Model
{
    protected $table = 'posts_tags_pivot';

    protected $guarded = [];
}
