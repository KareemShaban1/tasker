<?php

namespace App\Modules\Language\Models;

use App\Modules\Language\Database\Factories\LanguageFactory;
use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;

class Language extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filter;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'languages';


    public array $filterProperties = [
        'name' => 'search',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','is_active','created_at'];

    public static function newFactory(): Factory
    {
        return new LanguageFactory();
    }
}
