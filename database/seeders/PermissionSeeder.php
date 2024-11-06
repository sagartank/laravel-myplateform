<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $create = 'Create';
        $delete = 'Delete';
        $edit = 'Edit';
        $detail = 'Details';
        $permissions = [
            [
                'name' => 'dashboard',
                'display_name' => 'Dashboard',
                'module' => null,
                'childs' => [
                    [
                        'name' => 'users',
                        'display_name' => 'Users',
                        'module' => 'Dashboard',
                        'childs' => [],
                    ],
                    [
                        'name' => 'operations',
                        'display_name' => 'Operations',
                        'module' => 'Dashboard',
                        'childs' => [],
                    ],
                    [
                        'name' => 'offers',
                        'display_name' => 'Offers',
                        'module' => 'Dashboard',
                        'childs' => [],
                    ],
                    [
                        'name' => 'deals',
                        'display_name' => 'Deals',
                        'module' => 'Dashboard',
                        'childs' => [],
                    ]
                ],
            ],
            [
                'name' => 'user_master',
                'display_name' => 'User Master',
                'module' => null,
                'childs' => [
                    [
                        'name' => 'add-user',
                        'display_name' => 'Add User',
                        'module' => 'User Master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'edit-user',
                        'display_name' => $edit,
                        'module' => 'User Master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'view-user-detail',
                        'display_name' => $detail,
                        'module' => 'User Master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'delete-user',
                        'display_name' => $delete,
                        'module' => 'User Master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'permanent-delete-user',
                        'display_name' => 'Permanent Delete',
                        'module' => 'User Master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'export-users',
                        'display_name' => 'Export',
                        'module' => 'User Master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'edit-user-authentication-fields',
                        'display_name' => 'Edit Authentication Fields',
                        'module' => 'User Master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'user-accept-reject',
                        'display_name' => 'Accept / Reject',
                        'module' => 'User Master',
                        'childs' => [],
                    ]
                ],
            ],
            [
                'name' => 'role_master',
                'display_name' => 'Role Master',
                'module' => null,
                'childs' => [
                    [
                        'name' => 'add-role',
                        'display_name' => 'Add Role',
                        'module' => 'Role Master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'edit-role',
                        'display_name' => $edit,
                        'module' => 'Role Master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'delete-role',
                        'display_name' => $delete,
                        'module' => 'Role Master',
                        'childs' => [],
                    ]
                ],
            ],
            [
                'name' => 'operation_master',
                'display_name' => 'Operation Master',
                'module' => null,
                'childs' => [
                    [
                        'name' => 'export-operation',
                        'display_name' => 'Export',
                        'module' => 'Operation Master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'edit-operation',
                        'display_name' => $edit,
                        'module' => 'Operation Master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'delete-operation',
                        'display_name' => $delete,
                        'module' => 'Operation Master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'operation-status-update',
                        'display_name' => 'Status Update',
                        'module' => 'Operation Master',
                        'childs' => [],
                    ]
                ],
            ],
            [
                'name' => 'payer_issuer_master',
                'display_name' => 'Payer/Issuer Master',
                'module' => null,
                'childs' => [
                    [
                        'name' => 'add-payer-issuer',
                        'display_name' => 'Add',
                        'module' => 'payer_issuer_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'edit-payer-issuer',
                        'display_name' => $edit,
                        'module' => 'payer_issuer_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'delete-payer-issuer',
                        'display_name' => $delete,
                        'module' => 'payer_issuer_master',
                        'childs' => [],
                    ]
                ],
            ],
            [
                'name' => 'offer_master',
                'display_name' => 'Offer Master',
                'module' => null,
                'childs' => [
                    [
                        'name' => 'export-offer',
                        'display_name' => 'Export',
                        'module' => 'offer_master',
                        'childs' => [],
                    ]
                ],
            ],
            [
                'name' => 'deal_master',
                'display_name' => 'Deal Master',
                'module' => null,
                'childs' => [
                    [
                        'name' => 'export-deal',
                        'display_name' => 'Export',
                        'module' => 'deal_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'view-deal',
                        'display_name' => 'Details',
                        'module' => 'deal_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'back-forward-seller-deal',
                        'display_name' => 'Back/Forward Seller',
                        'module' => 'deal_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'back-forward-buyer-deal',
                        'display_name' => 'Back/Forward Buyer',
                        'module' => 'deal_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'deal-export-to-pdf',
                        'display_name' => 'Export to PDF',
                        'module' => 'deal_master',
                        'childs' => [],
                    ]
                ],
            ],
            [
                'name' => 'progress_master',
                'display_name' => 'Progress Master',
                'module' => null,
                'childs' => [
                    [
                        'name' => 'add-progress',
                        'display_name' => 'Add',
                        'module' => 'progress_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'edit-progress',
                        'display_name' => $edit,
                        'module' => 'progress_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'delete-progress',
                        'display_name' => $delete,
                        'module' => 'progress_master',
                        'childs' => [],
                    ]
                ],
            ],
            [
                'name' => 'user_level_master',
                'display_name' => 'User Level Master',
                'module' => null,
                'childs' => [
                    [
                        'name' => 'add-user-level',
                        'display_name' => 'Add',
                        'module' => 'user_level_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'edit-user-level',
                        'display_name' => $edit,
                        'module' => 'user_level_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'delete-user-level',
                        'display_name' => $delete,
                        'module' => 'user_level_master',
                        'childs' => [],
                    ]
                ],
            ],
            [
                'name' => 'company_types_master',
                'display_name' => 'Company Types Master',
                'module' => null,
                'childs' => [
                    [
                        'name' => 'add-company-types',
                        'display_name' => 'Add',
                        'module' => 'company_types_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'edit-company-types',
                        'display_name' => $edit,
                        'module' => 'company_types_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'delete-company-types',
                        'display_name' => $delete,
                        'module' => 'company_types_master',
                        'childs' => [],
                    ]
                ],
            ],
            [
                'name' => 'settings',
                'display_name' => 'Settings',
                'module' => null,
                'childs' => [
                    [
                        'name' => 'setting-language',
                        'display_name' => 'Language',
                        'module' => 'settings',
                        'childs' => [],
                    ]
                ],
            ],
            [
                'name' => 'marketing_master',
                'display_name' => 'Marketing Master',
                'module' => null,
                'childs' => [
                    [
                        'name' => 'home-text-list',
                        'display_name' => 'Home Text List',
                        'module' => 'marketing_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'home-side-list',
                        'display_name' => 'Home Side List',
                        'module' => 'marketing_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'home-partner-list',
                        'display_name' => 'Home Partner List',
                        'module' => 'marketing_master',
                        'childs' => [],
                    ],
                    [
                        'name' => 'blog-list',
                        'display_name' => 'Blog List',
                        'module' => 'marketing_master',
                        'childs' => [
                            [
                                'name' => 'add-blog',
                                'display_name' => 'Add',
                                'module' => 'blog-list',
                                'childs' => [],
                            ],
                            [
                                'name' => 'edit-blog',
                                'display_name' => $edit,
                                'module' => 'blog-list',
                                'childs' => [],
                            ],
                            [
                                'name' => 'delete-blog',
                                'display_name' => $delete,
                                'module' => 'blog-list',
                                'childs' => [],
                            ]
                        ],
                    ],
                    [
                        'name' => 'faq-type-list',
                        'display_name' => 'FAQ TYPE List',
                        'module' => 'marketing_master',
                        'childs' => [
                            [
                                'name' => 'add-faq-type',
                                'display_name' => 'Add',
                                'module' => 'faq-type-list',
                                'childs' => [],
                            ],
                            [
                                'name' => 'edit-faq-type',
                                'display_name' => $edit,
                                'module' => 'faq-type-list',
                                'childs' => [],
                            ],
                            [
                                'name' => 'delete-faq-type',
                                'display_name' => $delete,
                                'module' => 'faq-type-list',
                                'childs' => [],
                            ]
                        ],
                    ],
                    [
                        'name' => 'faq-list',
                        'display_name' => 'FAQ LIST',
                        'module' => 'marketing_master',
                        'childs' => [
                            [
                                'name' => 'add-faq',
                                'display_name' => 'Add',
                                'module' => 'faq-list',
                                'childs' => [],
                            ],
                            [
                                'name' => 'edit-faq',
                                'display_name' => $edit,
                                'module' => 'faq-list',
                                'childs' => [],
                            ],
                            [
                                'name' => 'delete-faq',
                                'display_name' => $delete,
                                'module' => 'faq-list',
                                'childs' => [],
                            ]
                        ],
                    ],
                    [
                        'name' => 'social-media-list',
                        'display_name' => 'Social Media List',
                        'module' => 'marketing_master',
                        'childs' => [
                            [
                                'name' => 'add-social-media',
                                'display_name' => 'Add',
                                'module' => 'social-media-list',
                                'childs' => [],
                            ],
                            [
                                'name' => 'edit-social-media',
                                'display_name' => $edit,
                                'module' => 'social-media-list',
                                'childs' => [],
                            ],
                            [
                                'name' => 'delete-social-media',
                                'display_name' => $delete,
                                'module' => 'social-media-list',
                                'childs' => [],
                            ]
                        ],
                    ]
                ],
            ],
            [
                'name' => 'plans',
                'display_name' => 'Plans',
                'module' => null,
                'childs' => [
                    [
                        'name' => 'add-plans',
                        'display_name' => 'Add',
                        'module' => 'plans',
                        'childs' => [],
                    ],
                    [
                        'name' => 'edit-plans',
                        'display_name' => $edit,
                        'module' => 'plans',
                        'childs' => [],
                    ],
                    [
                        'name' => 'delete-plans',
                        'display_name' => $delete,
                        'module' => 'plans',
                        'childs' => [],
                    ]
                ],
            ],
          

            // User Side
            [
                'name' => 'user-side-dashboard',
                'display_name' => 'Dashboard',
                'module' => null,
                'is_for_user_side' => 1,
                'childs' => [
                    [
                        'name' => 'investor_dashboard',
                        'display_name' => 'Investor',
                        'module' => 'user-side-dashboard',
                        'is_for_user_side' => 1,
                        'childs' => [
                                [
                                    'name' => 'investor_incomes',
                                    'display_name' => 'Incomes',
                                    'module' => 'investor_dashboard',
                                    'is_for_user_side' => 1,
                                    'childs' => [
                                        [
                                            'name' => 'view-incomes',
                                            'display_name' => 'View',
                                            'module' => 'investor_incomes',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'filter-incomes',
                                            'display_name' => 'Filter',
                                            'module' => 'investor_incomes',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'export-filter',
                                            'display_name' => 'export',
                                            'module' => 'investor_incomes',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ]
                                    ],
                                ],
                                [
                                    'name' => 'investor_deal',
                                    'display_name' => 'Deals',
                                    'module' => 'investor_dashboard',
                                    'is_for_user_side' => 1,
                                    'childs' => [
                                        [
                                            'name' => 'view-deal',
                                            'display_name' => 'View',
                                            'module' => 'investor_deal',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'filter-deal',
                                            'display_name' => 'Filter',
                                            'module' => 'investor_deal',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'export-deal',
                                            'display_name' => 'Export',
                                            'module' => 'investor_deal',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ]
                                    ],
                                ],
                                [
                                    'name' => 'investor-risk-management',
                                    'display_name' => 'Risk Management',
                                    'module' => 'investor_dashboard',
                                    'is_for_user_side' => 1,
                                    'childs' => [
                                        [
                                            'name' => 'view-risk-management',
                                            'display_name' => 'View',
                                            'module' => 'investor-risk-management',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'filter-risk-management',
                                            'display_name' => 'Filter',
                                            'module' => 'investor-risk-management',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'export-risk-management',
                                            'display_name' => 'Export',
                                            'module' => 'investor-risk-management',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ]
                                    ],
                                ],
                                [
                                    'name' => 'latest-updates-in-deals',
                                    'display_name' => 'Latest Updates in deals',
                                    'module' => 'investor_dashboard',
                                    'is_for_user_side' => 1,
                                    'childs' => [],
                                ],
                                [
                                    'name' => 'latest-updates-in-deals-graph',
                                    'display_name' => 'Latest Updates in deals Graph',
                                    'module' => 'investor_dashboard',
                                    'is_for_user_side' => 1,
                                    'childs' => [],
                                ],
                                [
                                    'name' => 'filters-on-top',
                                    'display_name' => 'Filters on top',
                                    'module' => 'investor_dashboard',
                                    'is_for_user_side' => 1,
                                    'childs' => [],
                                ],
                                [
                                    'name' => 'sub-user-roi',
                                    'display_name' => 'Sub User ROI',
                                    'module' => 'investor_dashboard',
                                    'is_for_user_side' => 1,
                                    'childs' => [
                                        [
                                            'name' => 'view-all-sub-user-roi',
                                            'display_name' => 'View All',
                                            'module' => 'sub-user-roi',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'view-specific-user-sub-user-roi',
                                            'display_name' => 'View Specific User',
                                            'module' => 'sub-user-roi',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ]
                                    ],
                                ],
                                [
                                    'name' => 'important-data',
                                    'display_name' => 'Important Data',
                                    'module' => 'investor_dashboard',
                                    'is_for_user_side' => 1,
                                    'childs' => [
                                        [
                                            'name' => 'documents-purchased',
                                            'display_name' => 'Documents Purchased',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'documents-cashed',
                                            'display_name' => 'Documents Cashed',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'ongoing-deals',
                                            'display_name' => 'Ongoing Deals',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'pending-actions',
                                            'display_name' => 'Pending Actions',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'outmatched-offers',
                                            'display_name' => 'Outmatched Offers',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'total-profits',
                                            'display_name' => 'Total Profits',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'total-invested',
                                            'display_name' => 'Total Invested',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ]
                                        ,
                                        [
                                            'name' => 'overall-roi',
                                            'display_name' => 'Overall ROI',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ]
                                        ,
                                        [
                                            'name' => 'pending-actions',
                                            'display_name' => 'Pending Actions',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ]
                                        ,
                                        [
                                            'name' => 'unclosed-deals',
                                            'display_name' => 'Unclosed Deals',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'comissions-pending-in-qty',
                                            'display_name' => 'Comissions Pending in QTY',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'comissions-pending-in-value',
                                            'display_name' => 'Comissions Pending in Value',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'comissions-paid',
                                            'display_name' => 'Comissions Paid',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'total-saved-vs-regular-acct',
                                            'display_name' => 'Total Saved Vs. Regular Acct',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'micoins-available',
                                            'display_name' => 'MICOINS Available',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'micoins-cashed',
                                            'display_name' => 'MICoins Cashed',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'mipo-plus-qty',
                                            'display_name' => 'MIPO+ QTY',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'mipo-plus-value',
                                            'display_name' => 'MIPO+ Value',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'documents-due-less-7-days',
                                            'display_name' => 'Documents Due < 7 Days',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'documents-due-less-15-days',
                                            'display_name' => 'Documents Due <15 Days',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'documents-due-less-30-days',
                                            'display_name' => 'Documents Due <30 Days',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'documents-due-greater-30-days',
                                            'display_name' => 'Documents Due >30 Days',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'important-data-graph',
                                            'display_name' => 'Graph',
                                            'module' => 'important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ]
                                    ],
                                ],
                               
                            ],
                        ],
                        [
                            'name' => 'borrower',
                            'display_name' => 'Borrower',
                            'module' => 'user-side-dashboard',
                            'is_for_user_side' => 1,
                            'childs' => [
                                [
                                    'name' => 'borrower-finalized-deals',
                                    'display_name' => 'Finalized Deals',
                                    'module' => 'borrower',
                                    'is_for_user_side' => 1,
                                    'childs' => [],
                                ],
                                [
                                    'name' => 'borrower-deals',
                                    'display_name' => 'Deals',
                                    'module' => 'borrower',
                                    'is_for_user_side' => 1,
                                    'childs' => [],
                                ],
                                [
                                    'name' => 'borrower-finalized-operations',
                                    'display_name' => 'Finalized Operations',
                                    'module' => 'borrower',
                                    'is_for_user_side' => 1,
                                    'childs' => [],
                                ],
                                [
                                    'name' => 'borrower-latest-updates-in-deals',
                                    'display_name' => 'Latest Updates in deals',
                                    'module' => 'borrower',
                                    'is_for_user_side' => 1,
                                    'childs' => [],
                                ],
                                [
                                    'name' => 'borrower-latest-updates-in-deals-graph',
                                    'display_name' => 'Latest Updates in deals Graph',
                                    'module' => 'borrower',
                                    'is_for_user_side' => 1,
                                    'childs' => [],
                                ],
                                [
                                    'name' => 'borrower-filters-on-top',
                                    'display_name' => 'Filters on top',
                                    'module' => 'borrower',
                                    'is_for_user_side' => 1,
                                    'childs' => [],
                                ],
                                [
                                    'name' => 'borrower-sub-user-roi',
                                    'display_name' => 'Sub User ROI',
                                    'module' => 'borrower',
                                    'is_for_user_side' => 1,
                                    'childs' => [
                                        [
                                            'name' => 'view-all-borrower-sub-user-roi',
                                            'display_name' => 'View All',
                                            'module' => 'borrower-sub-user-roi',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'view-specific-borrower-user-sub-user-roi',
                                            'display_name' => 'View Specific User',
                                            'module' => 'borrower-sub-user-roi',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ]
                                    ],
                                ],
                                [
                                    'name' => 'borrower-important-data',
                                    'display_name' => 'Important Data',
                                    'module' => 'borrower',
                                    'is_for_user_side' => 1,
                                    'childs' => [
                                        [
                                            'name' => 'borrower-important-data-documents-sold',
                                            'display_name' => 'Documents Sold',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-documents-cashed',
                                            'display_name' => 'Documents Cashed',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-ongoing-deals',
                                            'display_name' => 'Ongoing Deals',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-pending-actions',
                                            'display_name' => 'Pending Actions',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-counter-offered',
                                            'display_name' => 'Counter Offered',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-total-sold',
                                            'display_name' => 'Total Sold',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-total-cashed',
                                            'display_name' => 'Total Cashed',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-overall-descount-perc',
                                            'display_name' => 'Overall Discount in %',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-rejected-offers',
                                            'display_name' => 'Rejected Offers',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-documents-sold-with-resources',
                                            'display_name' => 'Documents Sold with Resources',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-Docuemnts-sold-without-resource',
                                            'display_name' => 'Docuemnts Sold without resource',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-total-sold',
                                            'display_name' => 'Total Sold',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-best-seller',
                                            'display_name' => 'Best Seller',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-sales-success-rate',
                                            'display_name' => 'Sales Success Rate',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-documents-due-less-7-days',
                                            'display_name' => 'Documents Due <7 Days',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-documents-due-less-15-days',
                                            'display_name' => 'Documents Due <15 Days',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-documents-due-less-30-days',
                                            'display_name' => 'Documents Due <30 Days',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-documents-due-greater-30-days',
                                            'display_name' => 'Documents Due >30 Days',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ],
                                        [
                                            'name' => 'borrower-important-data-graph',
                                            'display_name' => 'Graph',
                                            'module' => 'borrower-important-data',
                                            'is_for_user_side' => 1,
                                            'childs' => [],
                                        ]
                                    ],
                                ]
                            ],
                        ]
                ],
            ],
            [
                'name' => 'explore-operations',
                'display_name' => 'Explore Operations',
                'module' => null,
                'is_for_user_side' => 1,
                'childs' => [
                    [
                        'name' => 'view-all-operations',
                        'display_name' => 'View All Operations',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'operations-in-usd',
                        'display_name' => 'Operations in USD',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'operations-in-gs',
                        'display_name' => 'Operations in Gs',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-checks',
                        'display_name' => 'Checks',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-contracts',
                        'display_name' => 'Contracts',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-invoices',
                        'display_name' => 'Invoices',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-others',
                        'display_name' => 'Others',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-export',
                        'display_name' => 'Export',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-documents',
                        'display_name' => 'Documents',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-export',
                        'display_name' => 'Export Operation',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-share-operation',
                        'display_name' => 'Share Operation',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-show-more',
                        'display_name' => 'Show More',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-with-resource',
                        'display_name' => 'With Recourse',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-witout-recourse',
                        'display_name' => 'Witout Recourse',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-preferred-mode',
                        'display_name' => 'Preferred Mode',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-due-anytime',
                        'display_name' => 'Due anytime',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-expired-documents',
                        'display_name' => 'Expired Documents',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-paying-bank',
                        'display_name' => 'Paying Bank',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-payer',
                        'display_name' => 'Payer',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-payee',
                        'display_name' => 'Payee',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-bcp',
                        'display_name' => 'BCP',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-inforconf',
                        'display_name' => 'Inforconf',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-infocheck',
                        'display_name' => 'Infocheck',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-criterium',
                        'display_name' => 'Criterium',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-expiration-date',
                        'display_name' => 'Expiration Date',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-expiration-countdown',
                        'display_name' => 'Expiration countdown',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-mipo-plus',
                        'display_name' => 'mipo+',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-user-status',
                        'display_name' => 'User Status',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-document-attached-icon',
                        'display_name' => 'Document Attached Icon',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-stars',
                        'display_name' => 'Stars',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-written-review',
                        'display_name' => 'Written Review',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-comercial-reference',
                        'display_name' => 'Comercial Reference',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-can-offer',
                        'display_name' => 'Can Offer?',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-check-offered-operations',
                        'display_name' => 'Check Offered Operations',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-can-counter-offer',
                        'display_name' => 'Can Counter Offer',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'explore-operations-can-view-logs',
                        'display_name' => 'Can View Logs',
                        'module' => 'explore-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ]
                ],
            ],
            [
                'name' => 'my-operations',
                'display_name' => 'My Operations',
                'module' => null,
                'is_for_user_side' => 1,
                'childs' => [
                    [
                        'name' => 'my-operations-offers',
                        'display_name' => 'Offers',
                        'module' => 'my-operations',
                        'is_for_user_side' => 1,
                        'childs' => [
                            [
                                'name' => 'my-operations-can-view-offers',
                                'display_name' => 'Can View Offers',
                                'module' => 'my-operations-offers',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'my-operations-can-reject',
                                'display_name' => 'Can Reject',
                                'module' => 'my-operations-offers',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'my-operations-can-accept',
                                'display_name' => 'Can Accept',
                                'module' => 'my-operations-offers',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'my-operations-can-counter-offer',
                                'display_name' => 'Can Counter Offer',
                                'module' => 'my-operations-offers',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'my-operations-has-limit-over-counter-offer',
                                'display_name' => 'Has Limit Over Counter Offer?',
                                'module' => 'my-operations-offers',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ]
                        ],
                    ],
                    [
                        'name' => 'my-operations-create',
                        'display_name' => 'Can Create an Operation?',
                        'module' => 'my-operations',
                        'is_for_user_side' => 1,
                        'childs' => [
                            [
                                'name' => 'my-operations-create-check',
                                'display_name' => 'Check',
                                'module' => 'my-operations-create',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'my-operations-create-invoices',
                                'display_name' => 'Invoices',
                                'module' => 'my-operations-create',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'my-operations-create-contracts',
                                'display_name' => 'Contracts',
                                'module' => 'my-operations-create',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'my-operations-create-others',
                                'display_name' => 'Others',
                                'module' => 'my-operations-create',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ]
                        ],
                    ],
                    [
                        'name' => 'my-operations-tab-operations',
                        'display_name' => 'Operations',
                        'module' => 'my-operations',
                        'is_for_user_side' => 1,
                        'childs' => [
                            [
                                'name' => 'my-operations-tab-operations-adanced-fiters',
                                'display_name' => 'Adanced Fiters',
                                'module' => 'my-operations-tab-operations',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'my-operations-tab-operations-delete',
                                'display_name' => 'Delete',
                                'module' => 'my-operations-tab-operations',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'my-operations-tab-operations-revert',
                                'display_name' => 'Revert',
                                'module' => 'my-operations-tab-operations',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'my-operations-tab-operations-edit',
                                'display_name' => 'Edit',
                                'module' => 'my-operations-tab-operations',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ]
                        ],
                    ],
                    [
                        'name' => 'mi-operations',
                        'display_name' => 'MI OPERATIONS',
                        'module' => 'my-operations',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                ],
            ],
            [
                'name' => 'buyer-seller-deals',
                'display_name' => 'DEALS',
                'module' => null,
                'is_for_user_side' => 1,
                'childs' => [
                    [
                        'name' => 'buyer-seller-deals-can-apply-filters',
                        'display_name' => 'Can apply filters',
                        'module' => 'buyer-seller-deals',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'buyer-seller-deals-can-open',
                        'display_name' => 'Can Open Deals',
                        'module' => 'buyer-seller-deals',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'buyer-seller-deals-can-write-private-notes',
                        'display_name' => 'Can Write Private Notes?',
                        'module' => 'buyer-seller-deals',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'buyer-seller-deals-can-get-support',
                        'display_name' => 'Can Get Support',
                        'module' => 'buyer-seller-deals',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                ],
            ],
            [
                'name' => 'user-side-profile',
                'display_name' => 'Profile',
                'module' => null,
                'is_for_user_side' => 1,
                'childs' => [
                    [
                        'name' => 'user-side-profile-personal-details',
                        'display_name' => 'Personal Details',
                        'module' => 'user-side-profile',
                        'is_for_user_side' => 1,
                        'childs' => [
                            [
                                'name' => 'user-side-profile-can-edit',
                                'display_name' => 'Can Edit?',
                                'module' => 'user-side-profile-personal-details',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'user-side-profile-personal-details-change-password',
                                'display_name' => 'Can change password?',
                                'module' => 'user-side-profile-personal-details',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'user-side-profile-personal-details-verify-address',
                                'display_name' => 'Can verify Address',
                                'module' => 'user-side-profile-personal-details',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ]
                        ],
                    ],
                    [
                        'name' => 'user-side-credits',
                        'display_name' => 'Credits',
                        'module' => 'user-side-profile',
                        'is_for_user_side' => 1,
                        'childs' => [
                            [
                                'name' => 'user-side-credits-can-write-private-notes',
                                'display_name' => 'MICOINS',
                                'module' => 'user-side-credits',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'user-side-credits-can-redeem',
                                'display_name' => 'Can Redeem?',
                                'module' => 'user-side-credits',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ]
                        ],
                    ],
                    [
                        'name' => 'user-side-profile-manage-users',
                        'display_name' => 'Manage Users',
                        'module' => 'user-side-profile',
                        'is_for_user_side' => 1,
                        'childs' => [
                            [
                                'name' => 'user-side-profile-manage-users-add',
                                'display_name' => 'Add New User',
                                'module' => 'user-side-profile-manage-users',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'user-side-profile-manage-users-edit',
                                'display_name' => 'Edit User',
                                'module' => 'user-side-profile-manage-users',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ],
                            [
                                'name' => 'user-side-profile-manage-users-delete',
                                'display_name' => 'Delete User',
                                'module' => 'user-side-profile-manage-users',
                                'is_for_user_side' => 1,
                                'childs' => [],
                            ]
                        ],
                    ],
                    [
                        'name' => 'user-side-profile-settings',
                        'display_name' => 'Settings',
                        'module' => 'user-side-profile',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ],
                    [
                        'name' => 'user-side-profile-favorites',
                        'display_name' => 'Favorites',
                        'module' => 'user-side-profile',
                        'is_for_user_side' => 1,
                        'childs' => [],
                    ]
                ],
            ]
            
        ];
        foreach($permissions as $key => $val){
            $is_for_user_side = (isset($val['is_for_user_side'])) ? 1 : 0;
            $res = Permission::updateOrCreate(
                ['name' => $val['name']],
                ['display_name' => $val['display_name'],'module' => $val['module'],'is_for_user' => $is_for_user_side ]
            );
            if(count($val['childs']) > 0){
                $this->permissionRecursiveStore($res->id,$val['childs']);
            }
        }
        $role = Role::first();
        $permissionsIdArr = Permission::all()->pluck('id')->toArray();
        if($permissionsIdArr && count($permissionsIdArr) > 0){
            $role->syncPermissions($permissionsIdArr ?? []);
        }
    }
    public function permissionRecursiveStore($parent_id = null,$childs){
        foreach($childs as $key => $val){
            $is_for_user_side = (isset($val['is_for_user_side'])) ? 1 : 0;
            $res = Permission::updateOrCreate(
                ['name' => $val['name']],
                ['display_name' => $val['display_name'],'parent_id' => $parent_id,'module' => $val['module'],'is_for_user' => $is_for_user_side]
            );
            if(count($val['childs']) > 0){
                $this->permissionRecursiveStore($res->id,$val['childs']);
            }
        }
    }
}
