<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'limit_one_response',
        'creator_id',
    ];

    protected $casts = [
        'limit_one_response' => 'boolean',
    ];

    public function allowedDomains()
    {
        return $this->hasMany(AllowedDomain::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function scopeBySlug(Builder $query, string $slug)
    {
        $query->where('slug', $slug);
    }
}
