<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class RolePermissionSeeder.
 *
 * @see https://spatie.be/docs/laravel-permission/v5/basic-usage/multiple-guards
 *
 * @package App\Database\Seeds
 */
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Enable these options if you need same role and other permission for User Model
         * Else, please follow the below steps for admin guard
         */

        // Create Roles and Permissions
        // $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        // $roleAdmin = Role::create(['name' => 'admin']);
        // $roleEditor = Role::create(['name' => 'editor']);
        // $roleUser = Role::create(['name' => 'user']);


        // Permission List as array
        $permissions = [

            [
                'group_name' => 'client',
                'permissions' => [
                    'client.view',
                ]
            ],
            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                ]
            ],
            [
                'group_name' => 'services',
                'permissions' => [
                    // services Permissions
                    'services.create',
                    'services.view',
                    'services.edit',
                    'services.delete',
                ]
            ],
            [
                'group_name' => 'admin',
                'permissions' => [
                    // admin Permissions
                    'admin.create',
                    'admin.view',
                    'admin.edit',
                    'admin.delete',
                    'admin.approve',
                ]
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    // role Permissions
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                    'role.approve',
                ]
            ],
            [
                'group_name' => 'profile',
                'permissions' => [
                    // profile Permissions
                    'profile.view',
                    'profile.edit',
                    'profile.delete',
                    'profile.update',
                ]
            ],
            [
                'group_name' => 'category',
                'permissions' => [
                    // category Permissions
                    'category.view',
                    'category.edit',
                    'category.create',
                    'category.delete',
                    'category.update',
                ]
            ],
            [
                'group_name' => 'customer',
                'permissions' => [
                    // customer Permissions
                    'customer.view',
                    'customer.edit',
                    'customer.create',
                    'customer.delete',
                    'customer.update',
                ]
            ],
            [
                'group_name' => 'divisi',
                'permissions' => [
                    // divisi Permissions
                    'divisi.view',
                    'divisi.edit',
                    'divisi.create',
                    'divisi.delete',
                    'divisi.update',
                ]
            ],
            [
                'group_name' => 'monitoring',
                'permissions' => [
                    // monitoring Permissions
                    'monitoring.view',
                ]
            ],
            [
                'group_name' => 'quotation',
                'permissions' => [
                    // quotation Permissions
                    'quotation.view',
                    'quotation.edit',
                    'quotation.create',
                    'quotation.delete',
                    'quotation.update',
                ]
            ],
            [
                'group_name' => 'purchase order',
                'permissions' => [
                    // purchase order Permissions
                    'purchase.order.view',
                    'purchase.order.edit',
                    'purchase.order.create',
                    'purchase.order.delete',
                    'purchase.order.update',
                ]
            ],
            [
                'group_name' => 'invoice',
                'permissions' => [
                    // invoice Permissions
                    'invoice.view',
                    'invoice.edit',
                    'invoice.create',
                    'invoice.delete',
                    'invoice.update',
                    'invoice.payment',
                ]
            ],
            [
                'group_name' => 'project',
                'permissions' => [
                    // project Permissions
                    'project.view',
                    'project.edit',
                    'project.create',
                    'project.delete',
                    'project.update',
                ]
            ],
            [
                'group_name' => 'activity',
                'permissions' => [
                    // activity Permissions
                    'activity.view',
                    'activity.edit',
                    'activity.create',
                    'activity.delete',
                    'activity.update',
                ]
            ],
            [
                'group_name' => 'calendar',
                'permissions' => [
                    // calendar Permissions
                    'calendar.view',
                    'calendar.edit',
                    'calendar.create',
                    'calendar.delete',
                    'calendar.update',
                ]
            ],
            [
                'group_name' => 'team',
                'permissions' => [
                    // team Permissions
                    'team.view',
                    'team.edit',
                    'team.create',
                    'team.delete',
                    'team.update',
                ]
            ],
            [
                'group_name' => 'attendance',
                'permissions' => [
                    // attendance Permissions
                    'attendance.view',
                    'attendance.edit',
                    'attendance.create',
                    'attendance.delete',
                    'attendance.update',
                ]
            ],
            [
                'group_name' => 'assignment',
                'permissions' => [
                    // assignment Permissions
                    'assignment.view',
                    'assignment.edit',
                    'assignment.create',
                    'assignment.delete',
                    'assignment.update',
                    'assignment.approval',
                ]
            ],
            [
                'group_name' => 'state',
                'permissions' => [
                    // state Permissions
                    'state.view',
                    'state.edit',
                    'state.create',
                    'state.delete',
                    'state.update',
                ]
            ],
            [
                'group_name' => 'city',
                'permissions' => [
                    // city Permissions
                    'city.view',
                    'city.edit',
                    'city.create',
                    'city.delete',
                    'city.update',
                ]
            ],
            [
                'group_name' => 'category.document',
                'permissions' => [
                    // category.document Permissions
                    'category.document.view',
                    'category.document.edit',
                    'category.document.create',
                    'category.document.delete',
                    'category.document.update',
                ]
            ],
            [
                'group_name' => 'category.kajian',
                'permissions' => [
                    // category.kajian Permissions
                    'category.kajian.view',
                    'category.kajian.edit',
                    'category.kajian.create',
                    'category.kajian.delete',
                    'category.kajian.update',
                ]
            ],
            [
                'group_name' => 'category.simbg',
                'permissions' => [
                    // category.kajian Permissions
                    'category.simbg.view',
                    'category.simbg.edit',
                    'category.simbg.create',
                    'category.simbg.delete',
                    'category.simbg.update',
                ]
            ],
        ];


        // Create and Assign Permissions
        // for ($i = 0; $i < count($permissions); $i++) {
        //     $permissionGroup = $permissions[$i]['group_name'];
        //     for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
        //         // Create Permission
        //         $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);
        //         $roleSuperAdmin->givePermissionTo($permission);
        //         $permission->assignRole($roleSuperAdmin);
        //     }
        // }

        // Do same for the admin guard for tutorial purposes.
        $admin = Admin::where('username', 'superadmin')->first();
        $roleSuperAdmin = $this->maybeCreateSuperAdminRole($admin);

        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                $permissionExist = Permission::where('name', $permissions[$i]['permissions'][$j])->first();
                if (is_null($permissionExist)) {
                    $permission = Permission::create(
                        [
                            'name' => $permissions[$i]['permissions'][$j],
                            'group_name' => $permissionGroup,
                            'guard_name' => 'admin'
                        ]
                    );
                    $roleSuperAdmin->givePermissionTo($permission);
                    $permission->assignRole($roleSuperAdmin);
                }
            }
        }

        // Assign super admin role permission to superadmin user
        if ($admin) {
            $admin->assignRole($roleSuperAdmin);
        }
    }

    private function maybeCreateSuperAdminRole($admin): Role
    {
        if (is_null($admin)) {
            $roleSuperAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        } else {
            $roleSuperAdmin = Role::where('name', 'superadmin')->where('guard_name', 'admin')->first();
        }

        if (is_null($roleSuperAdmin)) {
            $roleSuperAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        }

        return $roleSuperAdmin;
    }
}
