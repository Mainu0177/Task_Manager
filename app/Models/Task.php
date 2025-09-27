<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'created_by',
        'assigned_to',
        'title',
        'description',
        'status',
    ];

    // define relationships if needed
    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo(){
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
