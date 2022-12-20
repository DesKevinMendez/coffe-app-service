<?php

namespace App\Models;

use App\Traits\usePaginate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission;

class SpatiePermissions extends Permission
{
    use usePaginate, HasFactory;
}
