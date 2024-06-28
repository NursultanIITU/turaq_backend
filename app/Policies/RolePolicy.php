<?php

namespace App\Policies;

use App\Models\AdminKitUser;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the adminKitUser can view any models.
     */
    public function viewAny(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('view_any_role');
    }

    /**
     * Determine whether the adminKitUser can view the model.
     */
    public function view(AdminKitUser $adminKitUser, Role $role): bool
    {
        return $adminKitUser->can('view_role');
    }

    /**
     * Determine whether the adminKitUser can create models.
     */
    public function create(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('create_role');
    }

    /**
     * Determine whether the adminKitUser can update the model.
     */
    public function update(AdminKitUser $adminKitUser, Role $role): bool
    {
        return $adminKitUser->can('update_role');
    }

    /**
     * Determine whether the adminKitUser can delete the model.
     */
    public function delete(AdminKitUser $adminKitUser, Role $role): bool
    {
        return $adminKitUser->can('delete_role');
    }

    /**
     * Determine whether the adminKitUser can bulk delete.
     */
    public function deleteAny(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('delete_any_role');
    }

    /**
     * Determine whether the adminKitUser can permanently delete.
     */
    public function forceDelete(AdminKitUser $adminKitUser, Role $role): bool
    {
        return $adminKitUser->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the adminKitUser can permanently bulk delete.
     */
    public function forceDeleteAny(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the adminKitUser can restore.
     */
    public function restore(AdminKitUser $adminKitUser, Role $role): bool
    {
        return $adminKitUser->can('{{ Restore }}');
    }

    /**
     * Determine whether the adminKitUser can bulk restore.
     */
    public function restoreAny(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the adminKitUser can replicate.
     */
    public function replicate(AdminKitUser $adminKitUser, Role $role): bool
    {
        return $adminKitUser->can('{{ Replicate }}');
    }

    /**
     * Determine whether the adminKitUser can reorder.
     */
    public function reorder(AdminKitUser $adminKitUser): bool
    {
        return $adminKitUser->can('{{ Reorder }}');
    }
}
