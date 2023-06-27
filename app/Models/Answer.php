<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        "response_id",
        "question_id",
        "value",
    ];

    public function Response()
    {
        return $this->belongsTo(Response::class, "response_id");
    }

    public function Question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    protected $hidden = ['created_at', 'updated_at'];
}
