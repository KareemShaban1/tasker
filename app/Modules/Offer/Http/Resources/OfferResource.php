<?php

namespace App\Modules\Offer\Http\Resources;

use App\Modules\Language\Http\Resources\LanguageResource;
use App\Modules\Language\Models\Language;
use App\Modules\TaskType\Http\Resources\TaskTypeResource;
use App\Modules\TaskType\Models\TaskType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'offer' => $this->offer,
            $this->mergeWhen(
                $this->withFullData,
                function () {
                    return [
                        'offer_limit' => $this->offer_limit,
                        'is_active' => $this->is_active,
                        'description' => $this->description,
                        'language_id' => $this->language_id,
                        'language' => (new LanguageResource(Language::find($this->language_id)))->withFullData(false),
                        'task_type_id' => $this->task_type_id,
                        'task_type' => (new TaskTypeResource(TaskType::find($this->task_type_id)))->withFullData(false),
                        'created_at' => $this->created_at,
                        'updated_at' => $this->updated_at,
                        'deleted_at' => $this->deleted_at,
                    ];
                }
            ),

        ];
    }
}
