<?php

namespace App\Policies\Stock;

use App\Models\User;
use App\Models\Stock\PostType;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny_PostType');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PostType $postType): bool
    {
        return $user->can('view_PostType');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_PostType');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PostType $postType): bool
    {
        return $user->can('update_PostType');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PostType $postType): bool
    {
        return $user->can('delete_PostType');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAny_PostType');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, PostType $postType): bool
    {
        return $user->can('forceDelete_PostType');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('forceDeleteAny_PostType');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, PostType $postType): bool
    {
        return $user->can('restore_PostType');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restoreAny_PostType');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, PostType $postType): bool
    {
        return $user->can('replicate_PostType');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_PostType');
    }
}
