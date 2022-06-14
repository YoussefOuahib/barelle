<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'address' => $this->address,
            'logo' => $this->logo,
            'map' => $this->map,
            'header_text' => $this->header_text,
            'footer_description' => $this->footer_description,
            'newsletter_header' => $this->newsletter_header,
            'newsletter_text' => $this->newsletter_text,
            
            
        ];
    }
}
