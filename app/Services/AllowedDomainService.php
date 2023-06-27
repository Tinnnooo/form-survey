<?php

namespace App\Services;

use App\Exceptions\ForbiddenAccess;

class AllowedDomainService
{
    public function userDomainCheck($user, $form)
    {
        $user_domain = substr(strrchr($user->email, "@"), 1);
        $allowed_domain = $form->allowedDomains->pluck("domain")->toArray();

        if($allowed_domain && !in_array($user_domain, $allowed_domain)) {
                throw new ForbiddenAccess("Forbidden access");
        }
    }
}
