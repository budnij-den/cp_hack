<?php

namespace App\Policies;

use App\User;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param \App\User $user
     * @param \App\Project $project
     * @return mixed
     */
    public function view(User $user, Project $project)
    {
        return $project->user_id == $user->id;
    }
}