<?php

namespace App\Observers;

use App\Helper\SearchLog;
use App\User;

class UserObserver
{
    public function created(User $user)
    {
        if ($user->is_admin == 0) {
            if ($user->is_admin == 0 && $user->is_employee == 0) {
                $type = 'Customer';
                $route = 'admin.customers.show';
            }

            if ($user->is_employee == 1) {
                $type = 'Employee';
                $route = 'admin.employee.edit';
            }

            SearchLog::createSearchEntry($user->id, $type, $user->name, $route);
            SearchLog::createSearchEntry($user->id, $type, $user->email, $route);
        }
    }

    public function updating(User $user)
    {
        if ($user->is_admin == 0) {
            if ($user->is_admin == 0 && $user->is_employee == 0) {
                $type = 'Customer';
                $route = 'admin.customers.show';
            }

            if ($user->is_employee == 1) {
                $type = 'Employee';
                $route = 'admin.employee.edit';
            }

            if ($user->isDirty('name')) {
                $original = $user->getOriginal('name');
                SearchLog::updateSearchEntry($user->id, $type, $user->name, $route, ['name' => $original]);
            }

            if ($user->isDirty('email')) {
                $original = $user->getOriginal('email');
                SearchLog::updateSearchEntry($user->id, $type, $user->email, $route, ['email' => $original]);
            }
        }
    }

    public function deleted(User $user)
    {
        if ($user->is_admin == 0) {
            if ($user->is_admin == 0 && $user->is_employee == 0) {
                $route = 'admin.customers.show';
            }

            if ($user->is_employee == 1) {
                $route = 'admin.employee.edit';
            }

            SearchLog::deleteSearchEntry($user->id, $route);
        }
    }
}
