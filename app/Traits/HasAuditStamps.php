<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasAuditStamps
{
    /**
     * Boot the audit stamps trait for the model.
     * Automatically captures created_by, updated_by, and request_uri.
     */
    public static function bootHasAuditStamps(): void
    {
        static::creating(function ($model) {
            $user = Auth::user();
            $username = $user ? ($user->username ?? $user->name ?? (string) $user->user_id) : (session('auth_user.username') ?? 'system');

            if (empty($model->created_by)) {
                $model->created_by = $username;
            }

            if (empty($model->updated_by)) {
                $model->updated_by = $username;
            }

            if (empty($model->request_uri)) {
                $model->request_uri = request() ? request()->path() : null;
            }
        });

        static::updating(function ($model) {
            $user = Auth::user();
            $username = $user ? ($user->username ?? $user->name ?? (string) $user->user_id) : (session('auth_user.username') ?? 'system');

            $model->updated_by = $username;

            if (request()) {
                $model->request_uri = request()->path();
            }
        });
    }
}
