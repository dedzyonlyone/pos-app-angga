<?php

namespace App\Support;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log(string $action, string $tableName, $recordId = null, $oldData = null, $newData = null): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'table_name' => $tableName,
            'record_id' => $recordId,
            'old_data' => $oldData ? (is_array($oldData) ? $oldData : $oldData->toArray()) : null,
            'new_data' => $newData ? (is_array($newData) ? $newData : $newData->toArray()) : null,
        ]);
    }
}