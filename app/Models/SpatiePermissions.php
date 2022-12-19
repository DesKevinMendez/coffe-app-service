<?php

namespace App\Models;

use App\Traits\usePaginate;
use Spatie\Permission\Models\Permission;

class SpatiePermissions extends Permission
{
    use usePaginate;
}
