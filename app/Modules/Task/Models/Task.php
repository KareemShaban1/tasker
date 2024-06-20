<?php

namespace App\Modules\Task\Models;

use App\Modules\City\Models\City;
use App\Modules\Client\Models\Client;
use App\Modules\Country\Models\Country;
use App\Modules\Language\Models\Language;
use App\Modules\State\Models\State;
use App\Modules\Task\Database\Factories\TaskFactory;
use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class Task extends Model
{
    use HasFactory;
    use Filter;
    use SoftDeletes;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';


    public array $filterProperties = [
        'title' => 'search',
        'language' => ['language' => ['name' => 'search']],
        'client' => ['client' => ['name' => 'search']],
        'country' => ['country' => ['name' => 'search']],
        'city' => ['city' => ['name' => 'search']],
        'state' => ['state' => ['name' => 'search']],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','description','price','source','image','video','is_active','client_id','language_id','location','country_id','city_id','state_id'];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://scotturb.com/wp-content/uploads/2016/11/product-placeholder-300x300.jpg';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/tasks/' . $this->image);
    }

    /**
    * Convert the model to an array.
    *
    * @return array
    */
    public function toArray()
    {
        $attributes = parent::toArray();

        // Append additional attributes to the array
        $attributes['image_url'] = $this->image_url;

        return $attributes;
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function language(){
        return $this->belongsTo(Language::class);
    }
    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function city(){
        return $this->belongsTo(City::class);
    }
    public function state(){
        return $this->belongsTo(State::class);
    }

    public static function newFactory(): Factory
    {
        return new TaskFactory();
    }

}
