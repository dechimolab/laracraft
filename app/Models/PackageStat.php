<?php

namespace App\Models;

use App\Traits\HasAuditStamps;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'package_name',
    'source',
    'category',
    'stars',
    'downloads_monthly',
    'downloads_total',
    'latest_version',
    'php_requirement',
    'laravel_requirement',
    'is_abandoned',
    'abandoned_replacement',
    'is_archived',
    'last_pushed_at',
    'synced_at',
    'sync_status',
    'sync_error',
    'created_by',
    'updated_by',
    'request_uri',
])]
class PackageStat extends Model
{
    use HasFactory, HasAuditStamps;

    protected $table = 'package_stats';
    protected $primaryKey = 'pkst_id';

    protected function casts(): array
    {
        return [
            'stars'              => 'integer',
            'downloads_monthly'  => 'integer',
            'downloads_total'    => 'integer',
            'is_abandoned'       => 'boolean',
            'is_archived'        => 'boolean',
            'last_pushed_at'     => 'datetime',
            'synced_at'          => 'datetime',
        ];
    }

    /**
     * Format stars to compact string e.g. 14.8k, 850
     */
    public function getStarsFormattedAttribute(): string
    {
        $stars = (int) ($this->stars ?? 0);
        if ($stars >= 1000) {
            $formatted = number_format($stars / 1000, 1);
            return rtrim(rtrim($formatted, '0'), '.') . 'k';
        }
        return (string) $stars;
    }

    /**
     * Format monthly downloads to compact string e.g. 1.2M, 45.2k
     */
    public function getDownloadsFormattedAttribute(): string
    {
        $dl = (int) ($this->downloads_monthly ?? 0);
        if ($dl >= 1000000) {
            $formatted = number_format($dl / 1000000, 1);
            return rtrim(rtrim($formatted, '0'), '.') . 'M';
        }
        if ($dl >= 1000) {
            $formatted = number_format($dl / 1000, 1);
            return rtrim(rtrim($formatted, '0'), '.') . 'k';
        }
        return (string) $dl;
    }
}
