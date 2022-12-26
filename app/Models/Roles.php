<?php

namespace App\Models;

use App\Traits\usePaginate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class Roles extends Role
{
    use HasFactory, usePaginate, SoftDeletes;
}
