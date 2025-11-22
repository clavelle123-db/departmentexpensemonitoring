<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budgets'; // ensure it points to your table
    protected $primaryKey = 'id'; // your primary key

    protected $fillable = [
        'department_id',
        'total_amount',
        'spent_amount',
        'remaining_amount',
        'amount', // if you also have a raw amount
    ];

    public $timestamps = true;
}
