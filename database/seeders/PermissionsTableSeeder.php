<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 20,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 21,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 22,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 23,
                'title' => 'post_management_access',
            ],
            [
                'id'    => 24,
                'title' => 'post_create',
            ],
            [
                'id'    => 25,
                'title' => 'post_edit',
            ],
            [
                'id'    => 26,
                'title' => 'post_show',
            ],
            [
                'id'    => 27,
                'title' => 'post_delete',
            ],
            [
                'id'    => 28,
                'title' => 'post_access',
            ],
            [
                'id'    => 29,
                'title' => 'category_create',
            ],
            [
                'id'    => 30,
                'title' => 'category_edit',
            ],
            [
                'id'    => 31,
                'title' => 'category_show',
            ],
            [
                'id'    => 32,
                'title' => 'category_delete',
            ],
            [
                'id'    => 33,
                'title' => 'category_access',
            ],
            [
                'id'    => 34,
                'title' => 'animal_create',
            ],
            [
                'id'    => 35,
                'title' => 'animal_edit',
            ],
            [
                'id'    => 36,
                'title' => 'animal_show',
            ],
            [
                'id'    => 37,
                'title' => 'animal_delete',
            ],
            [
                'id'    => 38,
                'title' => 'animal_access',
            ],
            [
                'id'    => 39,
                'title' => 'answer_create',
            ],
            [
                'id'    => 40,
                'title' => 'answer_edit',
            ],
            [
                'id'    => 41,
                'title' => 'answer_show',
            ],
            [
                'id'    => 42,
                'title' => 'answer_delete',
            ],
            [
                'id'    => 43,
                'title' => 'answer_access',
            ],
            [
                'id'    => 44,
                'title' => 'reports_abuse_create',
            ],
            [
                'id'    => 45,
                'title' => 'reports_abuse_edit',
            ],
            [
                'id'    => 46,
                'title' => 'reports_abuse_show',
            ],
            [
                'id'    => 47,
                'title' => 'reports_abuse_delete',
            ],
            [
                'id'    => 48,
                'title' => 'reports_abuse_access',
            ],
            [
                'id'    => 49,
                'title' => 'vote_create',
            ],
            [
                'id'    => 50,
                'title' => 'vote_edit',
            ],
            [
                'id'    => 51,
                'title' => 'vote_show',
            ],
            [
                'id'    => 52,
                'title' => 'vote_delete',
            ],
            [
                'id'    => 53,
                'title' => 'vote_access',
            ],
            [
                'id'    => 54,
                'title' => 'comment_create',
            ],
            [
                'id'    => 55,
                'title' => 'comment_edit',
            ],
            [
                'id'    => 56,
                'title' => 'comment_show',
            ],
            [
                'id'    => 57,
                'title' => 'comment_delete',
            ],
            [
                'id'    => 58,
                'title' => 'comment_access',
            ],
            [
                'id'    => 59,
                'title' => 'follow_create',
            ],
            [
                'id'    => 60,
                'title' => 'follow_edit',
            ],
            [
                'id'    => 61,
                'title' => 'follow_show',
            ],
            [
                'id'    => 62,
                'title' => 'follow_delete',
            ],
            [
                'id'    => 63,
                'title' => 'follow_access',
            ],
            [
                'id'    => 64,
                'title' => 'pet_create',
            ],
            [
                'id'    => 65,
                'title' => 'pet_edit',
            ],
            [
                'id'    => 66,
                'title' => 'pet_show',
            ],
            [
                'id'    => 67,
                'title' => 'pet_delete',
            ],
            [
                'id'    => 68,
                'title' => 'pet_access',
            ],
            [
                'id'    => 69,
                'title' => 'user_address_create',
            ],
            [
                'id'    => 70,
                'title' => 'user_address_edit',
            ],
            [
                'id'    => 71,
                'title' => 'user_address_show',
            ],
            [
                'id'    => 72,
                'title' => 'user_address_delete',
            ],
            [
                'id'    => 73,
                'title' => 'user_address_access',
            ],
            [
                'id'    => 74,
                'title' => 'team_create',
            ],
            [
                'id'    => 75,
                'title' => 'team_edit',
            ],
            [
                'id'    => 76,
                'title' => 'team_show',
            ],
            [
                'id'    => 77,
                'title' => 'team_delete',
            ],
            [
                'id'    => 78,
                'title' => 'team_access',
            ],
            [
                'id'    => 79,
                'title' => 'breed_create',
            ],
            [
                'id'    => 80,
                'title' => 'breed_edit',
            ],
            [
                'id'    => 81,
                'title' => 'breed_show',
            ],
            [
                'id'    => 82,
                'title' => 'breed_delete',
            ],
            [
                'id'    => 83,
                'title' => 'breed_access',
            ],
            [
                'id'    => 84,
                'title' => 'like_create',
            ],
            [
                'id'    => 85,
                'title' => 'like_edit',
            ],
            [
                'id'    => 86,
                'title' => 'like_show',
            ],
            [
                'id'    => 87,
                'title' => 'like_delete',
            ],
            [
                'id'    => 88,
                'title' => 'like_access',
            ],
            [
                'id'    => 89,
                'title' => 'dislike_create',
            ],
            [
                'id'    => 90,
                'title' => 'dislike_edit',
            ],
            [
                'id'    => 91,
                'title' => 'dislike_show',
            ],
            [
                'id'    => 92,
                'title' => 'dislike_delete',
            ],
            [
                'id'    => 93,
                'title' => 'dislike_access',
            ],
            [
                'id'    => 94,
                'title' => 'view_create',
            ],
            [
                'id'    => 95,
                'title' => 'view_edit',
            ],
            [
                'id'    => 96,
                'title' => 'view_show',
            ],
            [
                'id'    => 97,
                'title' => 'view_delete',
            ],
            [
                'id'    => 98,
                'title' => 'view_access',
            ],
            [
                'id'    => 99,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
