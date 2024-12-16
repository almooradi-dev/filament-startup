<?php

namespace App\Policies\Stock;

use App\Models\User;
use App\Models\Stock\PostCollection;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostCollectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny_PostCollection');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PostCollection $postCollection): bool
    {
        return $user->can('view_PostCollection');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_PostCollection');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PostCollection $postCollection): bool
    {
        return $user->can('update_PostCollection');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PostCollection $postCollection): bool
    {
        return $user->can('delete_PostCollection');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAny_PostCollection');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, PostCollection $postCollection): bool
    {
        return $user->can('forceDelete_PostCollection');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('forceDeleteAny_PostCollection');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, PostCollection $postCollection): bool
    {
        return $user->can('restore_PostCollection');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restoreAny_PostCollection');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, PostCollection $postCollection): bool
    {
        return $user->can('replicate_PostCollection');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_PostCollection');
    }
}
