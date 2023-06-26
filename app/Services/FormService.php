<?php

namespace App\Services;

use Exception;
use App\Models\Form;
use App\Models\AllowedDomain;
use Illuminate\Support\Facades\DB;
use App\Traits\RespondsWithHttpStatus;
use App\Exceptions\DataNotFoundException;

class FormService
{
    public function newForm(array $userForm, int $user_id)
    {
        DB::beginTransaction();

        try {
            $user_form = Form::create([
                "name" => $userForm['name'],
                "slug" => $userForm['slug'],
                "description" => $userForm['description'] ?? "",
                "limit_one_response" => $userForm['limit_one_response'] ?? false,
                "creator_id" => $user_id,
            ]);

            $this->storeFormAllowedDomain($userForm, $user_form);

            return $user_form;

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function storeFormAllowedDomain($userForm, $form)
    {
        $form_allowed_domain = [];
        foreach($userForm['allowed_domains'] as $domain)
        {
            $form_allowed_domain[] = new AllowedDomain([
                "form_id"=> $form->id,
                "domain" => $domain
            ]);
        }

        $form->allowedDomains()->saveMany($form_allowed_domain);
    }

    public function getAllUserForm(int $user_id)
    {
        $user_forms = Form::where('creator_id', $user_id)->get();

        if (empty($user_forms)){
            throw new DataNotFoundException;
        }

        return $user_forms;
    }
}
