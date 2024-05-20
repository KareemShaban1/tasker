<?php

namespace App\Modules\State\Models;

use App\Modules\City\Models\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'states';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','city_id'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}