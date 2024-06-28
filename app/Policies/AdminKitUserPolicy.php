<?php

namespace App\Policies;

use App\Models\AdminKitUser;

use Illuminate\Auth\Access\HandlesAuthorization;

class AdminKitUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the adminKitUser can view any models.
     *
     * @param  \App\Models\AdminKitUser  $adminKitUser
     * @return bool
     */
    public function viewAny(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('view_any_user');
    }

    /**
     * Determine whether the adminKitUser can view the model.
     *
     * @param  \App\Models\AdminKitUser  $adminKitUser
     * @return bool
     */
    public function view(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('view_user');
    }

    /**
     * Determine whether the adminKitUser can create models.
     *
     * @param  \App\Models\AdminKitUser  $adminKitUser
     * @return bool
     */
    public function create(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('create_user');
    }

    /**
     * Determine whether the adminKitUser can update the model.
     *
     * @param  \App\Models\AdminKitUser  $adminKitUser
     * @return bool
     */
    public function update(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('update_user');
    }

    /**
     * Determine whether the adminKitUser can delete the model.
     *
     * @param  \App\Models\AdminKitUser  $adminKitUser
     * @return bool
     */
    public function delete(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('delete_user');
    }

    /**
     * Determine whether the adminKitUser can bulk delete.
     *
     * @param  \App\Models\AdminKitUser  $adminKitUser
     * @return bool
     */
    public function deleteAny(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('delete_any_user');
    }

    /**
     * Determine whether the adminKitUser can permanently delete.
     *
     * @param  \App\Models\AdminKitUser  $adminKitUser
     * @return bool
     */
    public function forceDelete(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('force_delete_user');
    }

    /**
     * Determine whether the adminKitUser can permanently bulk delete.
     *
     * @param  \App\Models\AdminKitUser  $adminKitUser
     * @return bool
     */
    public function forceDeleteAny(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('force_delete_any_user');
    }

    /**
     * Determine whether the adminKitUser can restore.
     *
     * @param  \App\Models\AdminKitUser  $adminKitUser
     * @return bool
     */
    public function restore(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('restore_user');
    }

    /**
     * Determine whether the adminKitUser can bulk restore.
     *
     * @param  \App\Models\AdminKitUser  $adminKitUser
     * @return bool
     */
    public function restoreAny(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('restore_any_user');
    }

    /**
     * Determine whether the adminKitUser can bulk restore.
     *
     * @param  \App\Models\AdminKitUser  $adminKitUser
     * @return bool
     */
    public function replicate(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('replicate_user');
    }

    /**
     * Determine whether the adminKitUser can reorder.
     *
     * @param  \App\Models\AdminKitUser  $adminKitUser
     * @return bool
     */
    public function reorder(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('reorder_user');
    }
}
