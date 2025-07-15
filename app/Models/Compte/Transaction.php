<?php

namespace App\Models\compte;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable=[
       "solde"
   ];


    //History validcolumn
    public function scopeValid($query){
        return $query
            ->whereNotNull('montant')
            ->whereNotNull('type_transaction');
    }

    public function compteSource():BelongsTo{
        return $this->belongsTo(CompteBancaire::class, 'compte_source_id');
    }

    public function compteDest():BelongsTo{
        return $this->belongsTo(CompteBancaire::class, 'compte_dest_id');
    }

}
