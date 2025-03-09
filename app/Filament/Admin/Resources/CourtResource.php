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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class CourtResource extends Resource
{
    protected static ?string $model = Court::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                Select::make('branch_id')
                    ->relationship(name: 'branch', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Branch'),
                Select::make('status')
                    ->options([
                        'open' => 'Open',
                        'closed' => 'Closed',
                        'under_maintenance' => 'Under Maintenance',
                    ])
                    ->default('open')
                    ->required(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('branch.name')->label('Branch')->sortable()->searchable(),
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
