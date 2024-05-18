<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
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
            'is_active' => $this->is_active, 
            $this->mergeWhen(
                $this->withFullData,
                function () {
                    return [
                        'note' => $this->note,
                        'parent_id' => $this->parent_id,
                        'parent' => (new CategoryResource($this->whenLoaded('parent')))->withFullData(false),
                        // 'created_by' => (new UserResource($this->whenLoaded('created_by')))->withFullData(false),
                        'task_type_id' => $this->task_type_id,
                        'task_type' => $this->whenLoaded('task_type'),
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