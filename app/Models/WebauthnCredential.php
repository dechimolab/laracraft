<?php

namespace App\Models;

use App\Traits\HasAuditStamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebauthnCredential extends Model
{
    use HasFactory, HasAuditStamps;

    protected $table = 'webauthn_credentials';

    protected $primaryKey = 'cred_id';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'credential_id',
        'public_key',
        'user_handle',
        'counter',
        'device_name',
        'transports',
        'aaguid',
        'last_used_at',
        'created_by',
        'updated_by',
        'request_uri',
    ];

    protected function casts(): array
    {
        return [
            'transports' => 'array',
            'last_used_at' => 'datetime',
            'counter' => 'integer',
        ];
    }

    /**
     * Get the user that owns the credential.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
