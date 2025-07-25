<?php

namespace App\Models\Compte;

use App\Models\Demande;
use App\Models\User;
use App\Models\VirtualCard\VirtualCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompteBancaire extends Model


{

    protected $table = 'compte_bancaire'; // laravel should use exactly this table name
    protected $fillable = [
        "solde"
        ];

    public function user(): BelongsTo{
        // declare the type of relation between account and the use
        // meaning the this account blogs to user
        return $this->belongsTo(User::class);
    }

    // Queries
    public  function demandes (){
        return $this->hasMany(Demande::class, 'compte_id');
    }


    // account has many source  transaction
    public function transactionSource():HasMany{
        return $this->hasMany(Transaction::class, 'compte_source_id');
    }

    // account destionation has many transaction
    public function transactionDest():HasMany{
        return $this->hasMnay(transaction::class, 'compte_dest_id');
    }


    // this card belog to this class
    public function virtualCards()
    {
        return $this->hasMany(VirtualCard::class, 'compte_id');
    }

    protected $casts = [
        // On ajoute cette ligne pour dire à Laravel que cette colonne est une date/heure
        'date_dernier_reset_retrait' => 'datetime',
    ];


}
