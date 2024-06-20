<?php

namespace App\Modules\Country\Models;

use App\Modules\Country\Database\Factories\CountryFactory;
use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;

class Country extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filter;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';

    public array $filterProperties = [
        'name' => 'search',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public static function newFactory(): Factory
    {
        return new CountryFactory();
    }
}
