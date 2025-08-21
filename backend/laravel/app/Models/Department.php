<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model {
    protected $fillable = ['name']; // Permite atribuição em massa para o campo 'name'
    public function items(): HasMany { return $this->hasMany(Item::class); }
}
