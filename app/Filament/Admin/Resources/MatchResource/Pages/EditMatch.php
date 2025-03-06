<?php

namespace App\Filament\Admin\Resources\MatchResource\Pages;

use App\Filament\Admin\Resources\MatchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMatch extends EditRecord
{
    protected static string $resource = MatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
