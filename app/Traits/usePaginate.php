<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait usePaginate
{
    public function scopeApplyPaginate(Builder $builder, $request)
    {
        return $builder->paginate(
            $perPage = $request->per_page,
            $columns = ['*'],
            $pageName = 'page',
            $page = $request->page
        )->appends($request->query());
    }
}
