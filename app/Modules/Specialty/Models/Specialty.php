<?php

namespace App\Modules\Specialty\Models;

use App\Modules\Specialty\Database\Factories\SpecialtyFactory;
use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;

class Specialty extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filter;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'specialties';

    public array $filterProperties = [
        'name' => 'search',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description','is_active'];

    public static function newFactory(): Factory
    {
        return new SpecialtyFactory();
    }
}
