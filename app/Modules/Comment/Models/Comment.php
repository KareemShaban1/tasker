<?php

namespace App\Models;

use App\Modules\Client\Models\Client;
use App\Modules\Task\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['comment','parent_id','task_id','type','source','client_id','is_active'];

    public function parent(){
        return $this->belongsTo(Comment::class);
    }
    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
