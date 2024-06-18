<?php

namespace App\Modules\Task\Http\Resources;

use App\Modules\City\Http\Resources\CityResource;
use App\Modules\City\Models\City;
use App\Modules\Client\Http\Resources\ClientResource;
use App\Modules\Client\Models\Client;
use App\Modules\Country\Http\Resources\CountryResource;
use App\Modules\Country\Models\Country;
use App\Modules\Language\Http\Resources\LanguageResource;
use App\Modules\Language\Models\Language;
use App\Modules\State\Http\Resources\StateResource;
use App\Modules\State\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    private bool $withFullData = true;

    public function withFullData(bool $withFullData): self
    {
        $this->withFullData = $withFullData;

        return $this;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // 'title','description','price','source','image','video','is_active','client_id','language_id','location','country_id','city_id','state_id'
        return [
            'id' => $this->id,
            'title' => $this->title,
            'is_active' => $this->is_active,
            $this->mergeWhen(
                $this->withFullData,
                function () {
                    return [
                        'description'=>$this->description,
                        'price'=>$this->price,
                        'source'=>$this->source,
                        'image'=>$this->image_url,
                        'video'=>$this->video,
                        'location'=>$this->location,
                        'country_id' => $this->country_id,
                        'country' => (new CountryResource(Country::find($this->country_id)))->withFullData(false),
                        'city_id' => $this->city_id,
                        'city' => (new CityResource(City::find($this->city_id)))->withFullData(false),
                        'state_id' => $this->state_id,
                        'state' => (new StateResource(State::find($this->state_id)))->withFullData(false),
                        'language_id' => $this->language_id,
                        'language' => (new LanguageResource(Language::find($this->language_id)))->withFullData(false),
                        'client_id' => $this->language_id,
                        'client' => (new ClientResource(Client::find($this->client_id)))->withFullData(false),
                    ];
                }
            ),
            'created_at' => $this->created_at,
            // 'created_by' => (new UserResource(User::find($this->created_by)))->withFullData(false),

            'updated_at' => $this->updated_at,
            // 'updated_by' => (new UserResource(User::find($this->updated_by)))->withFullData(false),

            'deleted_at' => $this->deleted_at,
            // 'deleted_by' => (new UserResource(User::find($this->deleted_by)))->withFullData(false),

        ];
    }
}
