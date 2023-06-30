<?php

namespace App\Services;

use App\Exceptions\ForbiddenAccessException;
use App\Exceptions\NotFoundException;
use App\Exceptions\SomethingWrongException;
use App\Models\AllowedDomain;
use App\Models\Form;
use Exception;
use Illuminate\Support\Facades\DB;

class FormService
{
    public function newForm(array $form_data, $user)
    {
        DB::beginTransaction();

        try {
            $form = Form::create([
                'name' => $form_data['name'],
                'slug' => $form_data['slug'],
                'description' => $form_data['description'] ?? '',
                'limit_one_response' => $form_data['limit_one_response'] ?? false,
                'creator_id' => $user->id,
            ]);

            $form_allowed_domains = [];
            foreach ($form_data['allowed_domains'] as $domain) {
                $form_allowed_domains[] = new AllowedDomain([
                    'domain' => $domain,
                ]);
            }

            $form->allowedDomains()->saveMany($form_allowed_domains);

            DB::commit();

            return $form;

        } catch (Exception $e) {
            DB::rollback();
            throw new SomethingWrongException;
        }
    }

    public function getUserForms($user)
    {
        $forms = $user->forms;

        if ($forms->count() === 0) {
            throw new NotFoundException('No form has been added');
        }

        return $forms;
    }

    public function getForm($slug)
    {
        $form = Form::bySlug($slug)->first();

        if (empty($form)) {
            throw new NotFoundException('Form not found');
        }

        return $form;
    }

    public function getUserForm($slug, $user)
    {
        $form = $this->getForm($slug);

        if (! $this->isCreatedByUser($form, $user)) {
            throw new ForbiddenAccessException;
        }

        return $form;
    }

    public function getAllowedForm($slug, $user)
    {
        $form = $this->getForm($slug);

        if (! $this->isUserDomainAllowed($user, $form)) {
            throw new ForbiddenAccessException;
        }

        return $form;
    }

    protected function isUserDomainAllowed($user, $form)
    {
        if (empty($form->allowedDomains)) {
            return true;
        }

        $user_domain = substr(strrchr($user->email, '@'), 1);

        return $form->allowedDomains()->where('domain', $user_domain)->exists();
    }

    protected function isCreatedByUser($form, $user)
    {
        return $form->creator_id === $user->id;
    }
}
