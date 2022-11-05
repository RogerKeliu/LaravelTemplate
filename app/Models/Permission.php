<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    use HasFactory;

        // Les dates han canviat a Laravle 7
        protected function serializeDate(\DateTimeInterface $date)
        {
            return $date->format('Y-m-d H:i:s');
        }
}
