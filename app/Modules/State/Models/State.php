<?php

namespace App\Modules\State\Models;

use App\Modules\City\Models\City;
use App\Modules\State\Database\Factories\StateFactory;
use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;

class State extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filter;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'states';

    
    public array $filterProperties = [
        'name' => 'search',
        'city_name' => ['city' => ['name' => 'search']],
    ];

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

    public static function newFactory(): Factory
    {
        return new StateFactory();
    }
}
