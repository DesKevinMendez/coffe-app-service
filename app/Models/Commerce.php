<?php

namespace App\Models;

use App\Traits\useIsActive;
use App\Traits\usePaginate;
use App\Traits\useSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Support\Str;

class Commerce extends Model
{
    use HasFactory,
        usePaginate,
        SoftDeletes,
        useSlug,
        useIsActive;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}
