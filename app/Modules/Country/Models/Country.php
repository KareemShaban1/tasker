<?php

namespace App\Modules\Country\Models;

use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
