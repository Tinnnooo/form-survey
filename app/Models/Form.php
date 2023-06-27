<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "slug",
        "description",
        "limit_one_response",
        "creator_id",
    ];

    protected $casts = [
        "limit_one_response" => "boolean",
    ];

    public function allowedDomains(){
        return $this->hasMany(AllowedDomain::class);
    }

    public function Questions(){
        return $this->hasMany(Question::class);
    }

}
