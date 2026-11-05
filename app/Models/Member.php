<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }
}