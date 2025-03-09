<?php

namespace App\Filament\Admin\Resources\CourtRelationManagerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class BranchesRelationManager extends RelationManager
{
    protected static string $relationship = 'courts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Toggle::make('use_branch_price')
                    ->label('Use Branch Price')
                    ->default(true)
                    ->live(),

                TextInput::make('price_per_hour')
                    ->visible(fn($get) => !$get('use_branch_price'))
                    ->label('Price per Hour (VNĐ)'),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Court')
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('price_per_hour')
                    ->sortable()
                    ->label('Price per Hour ($)'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
