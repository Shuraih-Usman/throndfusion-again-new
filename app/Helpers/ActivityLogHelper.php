<?php

namespace App\Helpers;

use App\Models\AdminModel\Activity;

    class ActivityLogHelper {

        public static function Log($action, $user_id, $description = NULL) {

            Activity::create([
                'user_id' => $user_id,
                'action' => $action,
                'description' => $description
            ]);
        }
    }
