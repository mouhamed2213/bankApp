<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Compte\CompteBancaire;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Demande extends Model
{
    protected $fillable = [
            'compte_id',
            'type',
            'date_demande',
    ];


    // relation to bank account
    public function comptes() : BelongsTo{
        return $this->belongsTo(CompteBancaire::class,'compte_id');
    }
}
