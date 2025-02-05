<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'social_accounts' => $this->socialAccounts->map(function ($account) {
                return [
                    'provider_name' => $account->provider_name,
                    'provider_id' => $account->provider_id,
                ];
            }),
        ];
    }
}
