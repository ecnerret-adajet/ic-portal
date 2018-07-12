<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Labor extends Model
{
    protected $fillable = [
        'name',
        'status',
    ];

    // Relationship Models

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function classification() {
        return $this->belongsTo(Classification::class);
    }

    // Custom to array casting
    
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company' => $this->company->name,
            'classfication' => $this->classification->name,
            'labor_code' => $this->labor_code,
            'card_no' => $this->card_on,
            'status' => $this->status,
        ];
    }
}
