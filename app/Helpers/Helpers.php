<?php

use App\Models\AuditLog;

if (!function_exists('logActivity')) {

    function logActivity($action, $module, $description = null)
    {
        AuditLog::create([
            'user_id'    => auth()->id(),
            'action'     => $action,
            'module'     => $module,
            'description'=> $description,
        ]);
    }

}
