<?php

namespace App\Models\Compte;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompteBancaire extends Model


{

    protected $table = 'compte_bancaire'; // laravel should use exactly this table name

    public function user(): BelongsTo{
        // declare the type of relation between account and the use
        // meaning the this account blogs to user
        return $this->belongsTo(User::class);
    }


    // account has many source  transaction
    public function transactionSource():HasMany{
        return $this->hasMany(Transaction::class, 'compte_source_id');
    }

    // account destionation has many transaction
    public function transactionDest():HasMany{
        return $this->hasMnay(transaction::class, 'compte_dest_id');
    }


}
