<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function customer()
     {
         return $this->belongsTo(Customer::class);
     }

    // Definisikan relasi ke model Driver
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    // Definisikan relasi ke model Vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
