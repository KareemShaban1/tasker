<?php

namespace App\Modules\Category\Models;

use App\Modules\Category\Database\Factories\CategoryFactory;
use App\Modules\Language\Models\Language;
use App\Modules\TaskType\Models\TaskType;
use App\Modules\User\Models\User;
use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;


class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filter;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories'; 

    public array $filterProperties = [
        'name' => 'search',
        'language_name' => ['language' => ['name'=> 'search']],
        'task_type_name' => ['taskType' => ['type'=> 'search']],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','parent_id','task_type_id','is_active','language_id','created_by','updated_by','deleted_by'];

    public function parent(){
        return $this->belongsTo(Category::class,'parent_id','id');
    }

    public function task_type(){
        return $this->belongsTo(TaskType::class,'task_type_id','id');
    }

    
    public function language(){
        return $this->belongsTo(Language::class,'language_id','id');
    }

    
    public function created_by(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function updated_by(){
        return $this->belongsTo(User::class,'updated_by','id');
    }

    public function deleted_by(){
        return $this->belongsTo(User::class,'deleted_by','id');
    }
    
    public static function newFactory(): Factory
    {
        return new CategoryFactory();
    }

}
