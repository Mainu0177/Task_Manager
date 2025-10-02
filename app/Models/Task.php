<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    public const STATUSES = [
        'created',
        'assigned',
        'progress',
        'hold',
        'completed',
        'cancelled'
    ];
    protected $fillable = [
        'created_by',
        'title',
        'description',
        'status',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // define relationships if needed
    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

}
