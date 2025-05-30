<?php

namespace App\Filament\Kitchen\Resources\OrderResource\Pages;

use App\Filament\Kitchen\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
