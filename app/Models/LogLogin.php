<?php

namespace App\Models;

use App\Traits\HasAuditStamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogLogin extends Model
{
    use HasFactory, HasAuditStamps;

    protected $table = 'log_login';

    protected $primaryKey = 'lg_id';

    public $timestamps = true;

    protected $fillable = [
        'fac_id',
        'dep_id',
        'lg_date',
        'lg_ip',
        'lg_url',
        'username',
        'user_id',
        'psn_id',
        'lg_user_name',
        'lg_authority',
        'lg_action',
        'lg_browser',
        'lg_device',
        'lg_os',
        'created_by',
        'updated_by',
        'request_uri',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    protected function casts(): array
    {
        return [
            'lg_date' => 'datetime',
        ];
    }
}
