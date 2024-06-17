<?php

namespace App\Modules\City\Models;

use App\Modules\Country\Models\Country;
use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filter;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'cities';


    public array $filterProperties = [
        'name' => 'search',
        'country_name' => ['country' => ['name' => 'search']],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
