<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StartedImportResource\Pages;
use App\Filament\Resources\StartedImportResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class StartedImportResource extends Resource
{
    public static $icon = 'heroicon-o-cloud-download';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\Section::make('Notice!', 'Started Import data cannot be edited or manually created')
                    ->schema([
                        Components\Placeholder::make('', 'This form can only be used to view data.'),
                    ]),
                Components\TextInput::make('user_id')
                    ->required()
                    ->disabled()
                    ->label('User ID'),
                Components\Toggle::make('completed')
                    ->required()
                    ->disabled()
                    ->stacked(),
                Components\Toggle::make('failed')
                    ->required()
                    ->disabled()
                    ->stacked(),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('id')
                    ->primary()
                    ->searchable()
                    ->sortable(),
                Columns\Text::make('uuid')
                    ->primary()
                    ->searchable()
                    ->sortable(),
                Columns\Text::make('user.username')
                    ->url(fn($import) => "https://base.phoenixvtc.com/users/{$import->user_id}", true)
                    ->searchable()
                    ->sortable(),
                Columns\Boolean::make('completed')
                    ->sortable(),
                Columns\Boolean::make('failed')
                    ->sortable(),
                Columns\Text::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('Completed Imports', fn ($query) => $query->where('completed', true)),
                Filter::make('Uncompleted Imports', fn ($query) => $query->where('completed', false)),
                Filter::make('Failed Imports', fn ($query) => $query->where('failed', true)),
                Filter::make('Successful Imports', fn ($query) => $query->where('failed', false)),
            ]);
    }

    public static function relations()
    {
        return [
            //
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListStartedImports::routeTo('/', 'index'),
            Pages\CreateStartedImport::routeTo('/create', 'create'),
            Pages\EditStartedImport::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
