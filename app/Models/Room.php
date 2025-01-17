<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'describe',
        'type_id',
        'is_active',
    ];
    public function type() {
        return $this->belongsTo(Type::class);
    }
}
