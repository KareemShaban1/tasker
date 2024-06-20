<?php

namespace App\Modules\Offer\Models;

use App\Modules\Language\Models\Language;
use App\Modules\Offer\Database\Factories\OfferFactory;
use App\Modules\TaskType\Models\TaskType;
use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;

class Offer extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filter;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'offers';

    public array $filterProperties = [
        'offer' =>'search',
        'task_type' => ['task_type' => ['type' => 'search']],
        'language' => ['language' => ['name'=> 'search']],
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['task_type_id','offer','description','offer_limit','is_active','language_id'];

    public function task_type(){
        return $this->belongsTo(TaskType::class,'task_type_id');
    }

    public function language(){
        return $this->belongsTo(Language::class,'language_id');
    }

    public static function newFactory(): Factory
    {
        return new OfferFactory();
    }


}
