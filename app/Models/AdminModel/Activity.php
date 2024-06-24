<?php

namespace App\Models\AdminModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Activity extends Model
{
    use HasFactory;

    public $table = 'activity';
    protected $fillable = [
        'user_id',
        'action',
        'description',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
