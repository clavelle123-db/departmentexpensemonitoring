<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remittance extends Model
{
    use HasFactory;

    protected $primaryKey = 'remittance_id'; // since PK is remittance_id
    public $timestamps = true;

   protected $fillable = [
    'treasurer_id',
    'event_id',
    'amount',
    'remittance_date',
    'remarks',
    'is_remitted'
];


    // Relationships
    public function treasurer()
    {
        return $this->belongsTo(Treasurer::class, 'treasurer_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
