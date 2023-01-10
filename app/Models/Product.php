<?php

namespace App\Models;

use App\Traits\usePaginate;
use App\Traits\useSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory, usePaginate, SoftDeletes, useSlug;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'isUnit' => 'boolean',
        'isActive' => 'boolean',
        'isTemporary' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->user_id = Auth::user()->id;
        });
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
