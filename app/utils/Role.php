<?php
namespace App\Utils;

class Role
{
  protected $roles = ['admin', 'superadmin', 'casher'];

  protected $permissions = [
    'can-view-roles',
    'can-edit-roles',
    'can-save-roles',
    'can-delete-roles',
  ];

  /**
   * Returns all roles.
   *
   * @return array
   */
  public function getRoles()
  {
    return $this->roles;
  }

  /**
   * Returns all permissions.
   *
   * @return array
   */
  public function getPermissions()
  {
    return $this->permissions;
  }
}
