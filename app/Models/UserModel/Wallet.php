<?php

namespace App\Models\UserModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference',
        'type',
        'status',
        'amount'
    ];
}
