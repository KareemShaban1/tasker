<?php

namespace App\Modules\State\Http\Resources;

use App\Modules\City\Http\Resources\CityResource;
use App\Modules\City\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
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
                        'city_id' => $this->city_id,
                        'city' => (new CityResource(City::find($this->city_id)))->withFullData(false),
                        'created_at' => $this->created_at,
                        'updated_at' => $this->updated_at,
                        'deleted_at' => $this->deleted_at,
                    ];
                }
            ),

        ];
    }
}