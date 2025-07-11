<?php

namespace App\Models\compte;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    public function compteSource():BelongsTo{
        return $this->belongsTo(CompteBancaire::class, 'compte_source_id');
    }

    public function compteDest():BelongsTo{
        return $this->belongsTo(CompteBancaire::class, 'compte_dest_id');
    }

}
