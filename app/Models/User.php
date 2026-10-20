<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasAuditStamps;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'citizen_id', 'password', 'active', 'role', 'timezone', 'git_signature', 'preferences', 'created_by', 'updated_by', 'request_uri'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasAuditStamps;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Check if user account is active.
     */
    public function isActive(): bool
    {
        return strtoupper((string) ($this->attributes['active'] ?? 'Y')) === 'Y';
    }

    /**
     * Check if user has administrative privileges.
     */
    public function isAdmin(): bool
    {
        return strtolower((string) ($this->attributes['role'] ?? 'developer')) === 'admin';
    }

    /**
     * Get the primary key value via id alias for backward compatibility.
     */
    public function getIdAttribute(): mixed
    {
        return $this->attributes['user_id'] ?? null;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'preferences' => 'array',
        ];
    }

    /**
     * Get the registered WebAuthn credentials for the user.
     */
    public function webauthnCredentials(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WebauthnCredential::class, 'user_id', 'user_id');
    }
}
