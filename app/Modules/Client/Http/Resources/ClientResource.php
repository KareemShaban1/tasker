<?php

namespace App\Modules\Client\Http\Resources;

use App\Modules\City\Http\Resources\CityResource;
use App\Modules\City\Models\City;
use App\Modules\Country\Http\Resources\CountryResource;
use App\Modules\Country\Models\Country;
use App\Modules\State\Http\Resources\StateResource;
use App\Modules\State\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            $this->mergeWhen(
                $this->withFullData,
                function () {
                    return [
                        'email'=>$this->email,
                        'phone'=>$this->phone,
                        'specialties'=>$this->specialties,
                        'description'=>$this->description,
                        'location'=>$this->location,
                        'country_id' => $this->country_id,
                        'country' => (new CountryResource(Country::find($this->country_id)))->withFullData(false),
                        'city_id'=>$this->city_id,
                        'city' => (new CityResource(City::find($this->city_id)))->withFullData(false),
                        'state_id'=>$this->state_id,
                        'state' => (new StateResource(State::find($this->state_id)))->withFullData(false),
                        'source' => $this->source,
                        'is_active' => $this->is_active,
                        'created_at' => $this->created_at,
                        'updated_at' => $this->updated_at,
                        'deleted_at' => $this->deleted_at,
                    ];
                }
            ),

        ];
    }
}
