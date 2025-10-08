<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

// class GroupUser extends Model
class GroupUser extends Pivot
{
    protected $table = 'group_user';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'group_id',
        'user_id'
    ];
}
