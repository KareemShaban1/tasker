<?php

namespace App\Modules\Client\Models;

use App\Modules\City\Models\City;
use App\Modules\Country\Models\Country;
use App\Modules\State\Models\State;
use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filter;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'clients';

    public array $filterProperties = [
        'name' => 'search',
        'country' => ['country' => ['name' => 'search']],
        'city' => ['city' => ['name' => 'search']],
        'state' => ['state' => ['name' => 'search']],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','email','phone','specialties','description','country_id','city_id','state_id','location','source','is_active'];

    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function city(){
        return $this->belongsTo(City::class);
    }
    public function state(){
        return $this->belongsTo(State::class);
    }
}
