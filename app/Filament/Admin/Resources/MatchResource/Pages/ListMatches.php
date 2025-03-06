<?php

namespace App\Filament\Admin\Resources\MatchResource\Pages;

use App\Filament\Admin\Resources\MatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMatches extends ListRecords
{
    protected static string $resource = MatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
