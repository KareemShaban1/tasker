<?php

namespace App\Modules\TaskType\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskTypeResource extends JsonResource
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
            'type' => $this->type,
            'is_active' => $this->is_active,
            $this->mergeWhen(
                $this->withFullData,
                function () {
                    return [
                        'language_id' => $this->language_id,
                        'language' => $this->whenLoaded('language'),
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