<?php

namespace App\Models\AdminModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Payment extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }
}
