<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BranchResource\Pages;
use App\Filament\Admin\Resources\BranchResource\RelationManagers;
use App\Filament\Admin\Resources\CourtRelationManagerResource\RelationManagers\BranchesRelationManager;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\RawJs;


class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('description')
                    ->maxLength(500),

                // 📌 Google Map Address Search
                TextInput::make('address')
                    ->placeholder('Search for an address...')
                    ->required(),

                TextInput::make('phone')
                    ->tel()
                    ->maxLength(20),

                TextInput::make('number_of_courts')
                    ->minValue(1)
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->label('Number of Courts'),

                Forms\Components\Repeater::make('opening_hours')
                    ->schema([
                        TextInput::make('day')->required(),
                        TextInput::make('open_time')->required(),
                        TextInput::make('close_time')->required(),
                    ])
                    ->label('Opening Hours')
                    ->collapsible(),

                TextInput::make('price_per_hour')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->label('Price per Hour (VNĐ)'),

                // 📌 Single Image Upload for Stadium Map
                Forms\Components\FileUpload::make('stadium_map')
                    ->image()
                    ->label('Stadium Map')
                    ->disk('public'),

                // 📌 Multiple Image Upload for Images
                Forms\Components\FileUpload::make('images')
                    ->image()
                    ->multiple()
                    ->label('Images')
                    ->disk('public'),
                Select::make('manager_id')
                    ->relationship(name: 'manager', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('address')->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('manager.name')->label('Manager')->searchable(),
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
            BranchesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }

    protected static ?string $navigationLabel = 'Chi nhánh';

    protected static ?string $navigationBadgeTooltip = 'Chi nhánh';
}
