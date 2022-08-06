<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    // https://laravel.com/docs/9.x/authorization#authorizing-resource-controllers

    // https://laravel.com/docs/9.x/authorization#policy-responses

    // Determinar el permiso para el método index
    public function viewAny(User $user)
    {
        return $user->role->slug === "guard";
    }

    // Determinar el permiso para el método show
    public function view(User $user, Report $report)
    {
        return $user->id === $report->user_id
        ? Response::allow()
        : Response::deny("You don't own this report.");
    }

    // Determinar el permiso para el método create
    public function create(User $user)
    {
        return $user->role->slug === "guard";
    }

    // Determinar el permiso para el método update
    public function update(User $user, Report $report)
    {
        return $user->id === $report->user_id
        ? Response::allow()
        : Response::deny("You don't own this report.");
    }

    // Determinar el permiso para el método delete
    public function delete(User $user, Report $report)
    {
        return $user->id === $report->user_id
            ? Response::allow()
            : Response::deny("You don't own this report.");
    }


}
