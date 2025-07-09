<?php

namespace App\Models\Compte;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompteBancaire extends Model


{

    protected $table = 'compte_bancaire'; // laravel should use exactly this table name

    public function user(): BelongsTo{ // declare the type of relation between account and the user
        return $this->belongsTo(User::class);
    }
}
