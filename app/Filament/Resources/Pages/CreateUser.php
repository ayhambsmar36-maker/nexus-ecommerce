<?php

namespace App\Filament\Resources\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Override;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
   
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = bcrypt($data['password']);
        return $data;       
    }
    // function to manage permission who access this page
  /*  protected function canCreate(): bool
    {
        return auth()->user()->hasPermissionTo('create users'); 
    }*/
}
