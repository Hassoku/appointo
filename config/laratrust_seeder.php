<?php

return [
    'role_structure' => [
        'administrator' => [
            'location' => [
                'permissions' => 'c,r,u,d',
                'description' => 'Location'
            ],
            'category' => [
                'permissions' => 'c,r,u,d',
                'description' => 'Category'
            ],
            'business_service' => [
                'permissions' => 'c,r,u,d',
                'description' => 'Business Service'
            ],
            'customer' => [
                'permissions' => 'c,r,u,d',
                'description' => 'Customer'
            ],
            'employee' => [
                'permissions' => 'c,r,u,d',
                'description' => 'Employee'
            ],
            'employee_group' => [
                'permissions' => 'c,r,u,d',
                'description' => 'Employee Group'
            ],
            'point_of_sale' => [
                'permissions' => 'c',
                'description' => 'Point Of Sale'
            ],
            'booking' => [
                'permissions' => 'c,r,u,d',
                'description' => 'Booking'
            ],
            'report' => [
                'permissions' => 'c,r,u,d',
                'description' => 'Report'
            ],
            'settings' => [
                'permissions' => 'm',
                'description' => 'Settings'
            ],
        ],
        'employee' => [
            'booking' => [
                'permissions' => 'r,u',
                'description' => 'Booking'
            ]
        ],
        'customer' => [
            'booking' => [
                'permissions' => 'r,u',
                'description' => 'Booking'
            ]
        ],
    ],
    'permission_structure' => [
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'm' => 'manage'
    ],
    'default_roles' => ['administrator', 'employee', 'customer']
];
