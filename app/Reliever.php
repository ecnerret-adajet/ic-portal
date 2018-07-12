<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reliever extends Model
{
    protected $fillabe = [
        'reasons',
        'from_date',
        'to_date',
        // 'status',
    ];

    // Model Relationships

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function fromWorker() {
        return $this->belongsTo(User::class,'from_worker');
    }

    public function toWorker() {
        return $this->belongsTo(User::class,'to_worker');
    }

    public function approvedBy() {
        return $this->belongsTo(User::class,'approved_by');
    }

}
