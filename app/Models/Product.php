<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guard_name = 'api';
    use HasFactory;

        // Les dates han canviat a Laravle 7
        protected function serializeDate(\DateTimeInterface $date)
        {
            return $date->format('Y-m-d H:i:s');
        }
}
