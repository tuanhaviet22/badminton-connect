<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;

class Price extends TextInput
{
    protected string $view = 'forms.components.price';

    public static function make(string $name): static
    {
        return parent::make($name)
            ->numeric()
            ->mask(RawJs::make('$money($input)'))
            ->stripCharacters(',');
    }
}
