<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Models\User;
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
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\ViewColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->readOnly()
                    ->disabled(),

                TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn($state) => bcrypt($state))
                    ->visibleOn('create'),

                TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),

                FileUpload::make('avatar')
                    ->image(),

                Textarea::make('bio')
                    ->maxLength(500),

                Select::make('skill_level')
                    ->options(User::SKILL_LEVELS)
                    ->required(),


                KeyValue::make('preferred_play_time')
                    ->label('Preferred Play Time')
                    ->helperText('Example: {"Monday": "18:00-20:00", "Wednesday": "20:00-22:00"}'),

                TextInput::make('location')
                    ->label('Location (Latitude,Longitude)')
                    ->helperText('Enter coordinates like: 10.762622, 106.660172'),

                Select::make('role')
                    ->options([
                        'player' => 'Player',
                        'court_manager' => 'Court Manager',
                    ])
                    ->required(),

                DateTimePicker::make('created_at')
                    ->label('Created At')
                    ->disabled(),

                DateTimePicker::make('updated_at')
                    ->label('Updated At')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->circular(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable(),

                TextColumn::make('phone'),

                TextColumn::make('skill_level')
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        return User::SKILL_LEVELS[$state] ?? 'Unknown';
                    })
                    ->colors([
                        User::SKILL_Y => 'gray',
                        User::SKILL_TBY => 'blue',
                        User::SKILL_TB => 'green',
                        User::SKILL_TB_PLUS => 'yellow',
                        User::SKILL_TBK => 'orange',
                        User::SKILL_K => 'red',
                    ]),

                TextColumn::make('role')
                    ->badge()
                    ->colors([
                        'player' => 'gray',
                        'court_manager' => 'green'
                    ])
                    ->sortable(),

                TextColumn::make('location')
                    ->label('Location')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->since()
                    ->sortable()
            ])
            ->filters([
                // Example filter by skill level
                Tables\Filters\SelectFilter::make('skill_level')
                    ->options([
                        'beginner' => 'Beginner',
                        'intermediate' => 'Intermediate',
                        'advanced' => 'Advanced',
                        'pro' => 'Pro',
                    ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
