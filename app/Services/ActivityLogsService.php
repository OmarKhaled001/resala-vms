<?php


namespace App\Services;

use App\Models\Activity_log;

class ActivityLogsService
{
    public function insert(array $data)
    {
        return Activity_log::create([
            'guard'         => $data['guard'],
            'causer_id'     => $data['causer']->id, 
            'causer_type'   => get_class($data['causer']),
            'subject_id'    => $data['subject']->id, 
            'subject_type'  => get_class($data['subject']),
            'log_name'      => $data['log_name'],
            'description'   => $data['description'] ?? null,
            'event'         => $data['event'] ?? null,
            'properties'    => json_encode($data['subject']->toArray()),
        ]);
    }
}
