<?php

namespace App\Policies\Stock;

use App\Models\User;
use App\Models\Stock\PostTag;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostTagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny_PostTag');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PostTag $postTag): bool
    {
        return $user->can('view_PostTag');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_PostTag');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PostTag $postTag): bool
    {
        return $user->can('update_PostTag');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PostTag $postTag): bool
    {
        return $user->can('delete_PostTag');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAny_PostTag');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, PostTag $postTag): bool
    {
        return $user->can('forceDelete_PostTag');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('forceDeleteAny_PostTag');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, PostTag $postTag): bool
    {
        return $user->can('restore_PostTag');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restoreAny_PostTag');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, PostTag $postTag): bool
    {
        return $user->can('replicate_PostTag');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_PostTag');
    }
}
