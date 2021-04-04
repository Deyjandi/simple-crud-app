<?php

namespace App\Traits;

use App\Models\User;
use App\Scopes\UserIdScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToUser
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootBelongsToUser()
    {
        static::addGlobalScope(new UserIdScope);
    }
}
