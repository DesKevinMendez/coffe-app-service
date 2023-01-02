<?php

namespace App\Models;

use App\Traits\{useIsActive, usePaginate, useSlug};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
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
}
