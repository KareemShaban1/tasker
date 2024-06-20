<?php

namespace App\Modules\User\Models;

use App\Modules\Country\Models\Country;
use App\Modules\User\Database\Factories\UserFactory;
use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;

class User extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filter;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'users';


    public array $filterProperties = [
        'name' => 'search',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','email','password'];

    public static function newFactory(): Factory
    {
        return new UserFactory();
    }
 
}
