<?php

namespace App\Models\VirtualCard;

use App\Models\Compte\CompteBancaire;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VirtualCard extends Model
{
    // carg belog to compte
    public function compte()
    {
        return $this->belongsTo(CompteBancaire::class, 'compte_id');
    }

}
