<?php

namespace App\Modules\TaskType\Models;

use App\Modules\Language\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskType extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type','is_active','language_id'];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }


    // public function created_by()
    // {
    //     return $this->belongsTo(User::class, 'created_by', 'id');
    // }

    // public function updated_by()
    // {
    //     return $this->belongsTo(User::class, 'updated_by', 'id');
    // }

    // public function deleted_by()
    // {
    //     return $this->belongsTo(User::class, 'deleted_by', 'id');
    // }
}