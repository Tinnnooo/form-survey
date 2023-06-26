<?php

namespace App\Services;

use App\Models\Form;

class QuestionService
{
    public function addQuestion($slug, $user)
    {
        $form = Form::where("slug", $slug)->first();


    }
}
