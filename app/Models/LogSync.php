<?php

namespace App\Models;

use App\Traits\HasAuditStamps;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'sync_source',
    'sync_status',
    'total_packages',
    'synced_count',
    'failed_count',
    'error_details',
    'triggered_by',
    'duration_ms',
    'created_by',
    'updated_by',
    'request_uri',
])]
class LogSync extends Model
{
    use HasFactory, HasAuditStamps;

    protected $table = 'log_sync';
    protected $primaryKey = 'sync_id';

    protected function casts(): array
    {
        return [
            'total_packages' => 'integer',
            'synced_count'   => 'integer',
            'failed_count'   => 'integer',
            'error_details'  => 'array',
            'duration_ms'    => 'integer',
        ];
    }
}
