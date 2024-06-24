<?php

namespace App\Models\UserModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Campaign extends Model
{
    use HasFactory;

    public function user() {

        return $this->belongsTo(User::class);
    }
}
