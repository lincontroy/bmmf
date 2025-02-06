<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'title'        => $this->title ?? 0,
            'description'  => $this->description ?? null,
            'email'        => $this->email ?? null,
            'phone'        => $this->phone ?? null,
            'logo'         => $this->logo ?? null,
            'logo_web'     => $this->logo_web ?? null,
            'favicon'      => $this->favicon ?? null,
            'language_id ' => $this->language_id ?? null,
            'site_align'   => $this->site_align ?? null,
            'footer_text'  => $this->footer_text ?? null,
            'time_zone'    => $this->time_zone ?? null,
            'office_time'  => $this->office_time ?? null,
        ];

        return $data;
    }
}
