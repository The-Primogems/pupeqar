<?php

namespace App\Policies\Authentication;

use App\Models\User;
use App\Models\Authentication\UserRole;
use App\Models\Authentication\RolePermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $roles = UserRole::where('user_roles.user_id', $user->id)
                 ->pluck('user_roles.role_id')->all();
        foreach ($roles as $role) {
            $permission = RolePermission::where('role_permissions.role_id', $role)
                            ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
                            ->where('permissions.name', "view users")
                            ->first();

            return $permission !== null ;

        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $roles = UserRole::where('user_roles.user_id', $user->id)
                 ->pluck('user_roles.role_id')->all();
        foreach ($roles as $role) {
            $permission = RolePermission::where('role_permissions.role_id', $role)
                            ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
                            ->where('permissions.name', "add users")
                            ->first();

            return $permission !== null ;

        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        $roles = UserRole::where('user_roles.user_id', $user->id)
                 ->pluck('user_roles.role_id')->all();
        foreach ($roles as $role) {
            $permission = RolePermission::where('role_permissions.role_id', $role)
                            ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
                            ->where('permissions.name', "edit user role")
                            ->first();

            return $permission !== null ;

        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        $roles = UserRole::where('user_roles.user_id', $user->id)
                 ->pluck('user_roles.role_id')->all();
        foreach ($roles as $role) {
            $permission = RolePermission::where('role_permissions.role_id', $role)
                            ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
                            ->where('permissions.name', "delete user record")
                            ->first();

            return $permission !== null ;

        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function is_super_admin(User $user) {
        $is_superadmin = UserRole::where('user_roles.user_id', $user->id)
            ->where('user_roles.user_id', 9)
            ->get();

            return $is_superadmin !== null ;
    }
}
