<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model {
    protected $primaryKey = 'section_id';
    protected $fillable = ['section_name', 'year_level','no_of_students'];

    public function events() {
        return $this->hasMany(Event::class, 'applied_to');
    }
public function treasurer() {
    return $this->belongsTo(User::class, 'treasurer_id', 'id')
                ->where('role', 'head'); // only fetch users with role 'head'
}


    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function headTreasurer() {
        return $this->hasOne(HeadTreasurer::class, 'section_assigned');
    }
}
