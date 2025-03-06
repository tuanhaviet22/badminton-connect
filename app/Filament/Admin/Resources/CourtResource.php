<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CourtResource\Pages;
use App\Filament\Admin\Resources\CourtResource\RelationManagers;
use App\Models\Court;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourtResource extends Resource
{
    protected static ?string $model = Court::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->label('Court Name'),
            Forms\Components\TextInput::make('location')->required()->label('Location'),
            Forms\Components\NumberInput::make('price_per_hour')->label('Price per Hour'),
            Forms\Components\Toggle::make('has_parking')->label('Has Parking'),
            Forms\Components\Toggle::make('has_locker_room')->label('Has Locker Room'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->sortable()->searchable()->label('Court Name'),
            Tables\Columns\TextColumn::make('location')->sortable()->searchable()->label('Location'),
            Tables\Columns\TextColumn::make('price_per_hour')->label('Price per Hour'),
            Tables\Columns\BooleanColumn::make('has_parking')->label('Parking Available'),
            Tables\Columns\BooleanColumn::make('has_locker_room')->label('Locker Room Available'),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourts::route('/'),
            'create' => Pages\CreateCourt::route('/create'),
            'edit' => Pages\EditCourt::route('/{record}/edit'),
        ];
    }
}
