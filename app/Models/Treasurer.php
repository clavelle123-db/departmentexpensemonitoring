<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\User;

class Treasurer extends Model {
    protected $primaryKey = 'treasurer_id';
    protected $fillable = [ 'user_id','section_assigned'];

    public function section() {
        return $this->belongsTo(Section::class, 'section_assigned');
    }

  public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}


    public function remittances() {
        return $this->hasMany(Remittance::class, 'treasurer_id');
    }
}
