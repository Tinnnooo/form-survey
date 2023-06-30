<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllowedDomain extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'domain',
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
