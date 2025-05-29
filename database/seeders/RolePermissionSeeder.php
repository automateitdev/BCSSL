<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::updateOrCreate(['name'=>'superadmin'],['name' => 'superadmin','guard_name'=>'admin']);
        $admin = Role::updateOrCreate(['name'=>'admin'],['name' => 'admin','guard_name'=>'admin']);
        $opertor = Role::updateOrCreate(['name'=>'operator'],['name' => 'operator','guard_name'=>'admin']);

        DB::table('permissions')->delete();
           //permission array
           $permissions = [
                [
                    'main_menue' => 'Dashboard',
                    'submenues' => [
                        [
                            'submenues' => 'Dashboard Section',
                            'permission' => [
                                'Deashboard View'
                            ]
                        ],

                    ],

                ],
                [
                    'main_menue' => 'Member Management',
                    'submenues' => [
                        [
                            'submenues' => 'Registration',
                            'permission' => [
                                'Registration Add',
                            ]
                        ],
                        [
                            'submenues' => 'Associators Info',
                            'permission' => [
                                'Associators Info View',
                                'Associators Info Edit',
                                // 'Associators Info Delete',
                            ]
                        ],
                        [
                            'submenues' => 'Profile Approval',
                            'permission' => [
                                'Profile Approval View',
                                'Profile Approval Edit',
                            ]
                        ],
                        [
                            'submenues' => 'Member List',
                            'permission' => [
                                'Member List View',
                                'Member List Edit',
                            ]
                        ],

                    ],
                ],
                [
                    'main_menue' => ' Fees Management',
                    'submenues' => [
                        [
                            'submenues' => 'Fee Setup',
                            'permission' => [
                                'Fee Setup View',
                                'Fee Setup Add',
                            ]
                        ],
                        [
                            'submenues' => 'Fee Assign',
                            'permission' => [
                                'Fee Assign View',
                                'Fee Assign Add',
                            ]
                        ],
                        [
                            'submenues' => 'Fee Collection',
                            'permission' => [
                                'Fee Collection View',
                            ]
                        ],
                        [
                            'submenues' => 'Quick Collection',
                            'permission' => [
                                'Quick Collection View',
                                'Quick Collection Add',
                            ]
                        ],
                        [
                            'submenues' => 'Quick Collection Invoices',
                            'permission' => [
                                'Quick Collection Invoices View',
                            ]
                        ],
                        [
                            'submenues' => 'Quick Collection Invoices pdf',
                            'permission' => [
                                'Quick Collection Invoices pdf View',
                            ]
                        ],
                        [
                            'submenues' => 'Payment Approval',
                            'permission' => [
                                'Payment Approval View',
                                'Payment Approval Edit',
                            ]
                        ],
                        [
                            'submenues' => 'Paid Info Report',
                            'permission' => [
                                'Paid Info Report View',
                            ]
                        ],
                        [
                            'submenues' => 'Paid Info Report Invoice',
                            'permission' => [
                                'Paid Info Report Invoice View',
                            ]
                        ],
                        [
                            'submenues' => 'Due Info Report',
                            'permission' => [
                                'Due Info Report View',
                            ]
                        ],


                    ],

                ],
                [
                    'main_menue' => 'Account Management',
                    'submenues' => [
                        [
                            'submenues' => 'Create Ledger',
                            'permission' => [
                                'Create Ledger View',
                                'Create Ledger Add',
                            ]
                        ],
                        [
                            'submenues' => 'Profile Update',
                            'permission' => [
                                'Profile Update View',
                                'Profile Update Edit',
                            ]
                        ],
                    ]
                ],
                [
                    'main_menue' => 'Core Setting',
                    'submenues' => [
                        [
                            'submenues' => 'Roles',
                            'permission' => [
                                'Roles View',
                                'Roles Add',
                                'Roles Edit',
                                'Roles Delete',
                            ]
                        ],
                        [
                            'submenues' => 'Users',
                            'permission' => [
                                'Users View',
                                'Users Add',
                                'Users Edit',
                                'Users Delete',
                            ]
                        ],
                    ]
                ],
            ];

            foreach ($permissions as $main_menue_key => $main_menue_value){
                // dd($main_menue_key, $main_menue_value,$main_menue_value['main_menue']);
                $main_menue_per = Permission::updateOrCreate(
                    ['name'=>$main_menue_value['main_menue']] ,
                    ['name'=>$main_menue_value['main_menue'] ,'guard_name'=>'admin' ]
                );
                // dd($main_menue_per);
                foreach($main_menue_value['submenues'] as $submenue){
                    $submenue_per = Permission::updateOrCreate(
                        ['name'=>$submenue['submenues']] ,
                        ['name'=>$submenue['submenues'], 'parent_id'=>$main_menue_per->id ,'guard_name'=>'admin' ]
                    );

                    foreach($submenue['permission'] as $permission){
                       $admin_permission = Permission::updateOrCreate(
                            ['name'=>$permission] ,
                            ['name'=>$permission, 'parent_id'=>$submenue_per->id ,'guard_name'=>'admin' ]
                        );
                        $superAdmin->givePermissionTo($admin_permission);
                    }
                }
            }

            $emails = User::$seederMail;

            foreach ($emails as $key=>$email){
                $user =  User::where('email',$email)->first();
                $user->assignRole($superAdmin->id);
            }
            // dd('created');
    }
}
