<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;
    public function departement()
    {
        return $this->belongsTo(departement::class);
    }
    public function payments()
    {
        return $this->hasMany(payment::class);
    }
}
