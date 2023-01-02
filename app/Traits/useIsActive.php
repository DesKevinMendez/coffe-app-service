<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait useIsActive
{
    public function scopeIsActive(Builder $builder, $activeBy = 'isActive')
    {
        return $builder->where($activeBy, true);
    }
}
