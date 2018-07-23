<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reliever extends Model
{
    protected $fillabe = [
        'reasons',
        'from_date',
        'to_date',
        'status',
        'user_id',
        'from_worker',
        'to_worker',
    ];

    // Model Relationships

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function fromWorker() {
        return $this->belongsTo(Labor::class,'from_worker');
    }

    public function toWorker() {
        return $this->belongsTo(Labor::class,'to_worker');
    }

    public function approvedBy() {
        return $this->belongsTo(Labor::class,'approved_by');
    }

    public function company() 
    {
        return $this->belongsTo(Company::class);
    }

    // Cast to JSON

    public function toArray() 
    {
        return  [
            'id' => $this->id,
            'from_worker' => $this->fromWorker->name,
            'to_worker' => $this->toWorker->name,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'company' => $this->company,
            'approved' => 'PENDING',

        ];
    }

}
