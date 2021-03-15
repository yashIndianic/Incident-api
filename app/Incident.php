<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'category_id', 'comments', 'incident_date'
    ];
    
    public function locations()
    {
        return $this->hasOne(Location::class, 'incident_id', 'id');
    }
    
    public function people(){
    return $this->hasMany(User::class, 'incident_id');
}
}
