<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FailedJobResource\Pages;
use App\Filament\Resources\FailedJobResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class FailedJobResource extends Resource
{
    public static $icon = 'heroicon-o-exclamation-circle';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\Section::make('Notice!', 'Failed Job data cannot be edited or manually created')
                    ->schema([
                        Components\Placeholder::make('', 'This form can only be used to view data.'),
                    ]),
                Components\TextInput::make('connection')
                    ->required()
                    ->disabled(),
                Components\TextInput::make('queue')
                    ->required()
                    ->disabled(),
                Components\TextArea::make('payload')
                    ->required()
                    ->disabled()
                    ->rows(10),
                Components\TextArea::make('exception')
                    ->required()
                    ->disabled()
                    ->rows(10),
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
                Columns\Text::make('connection')
                    ->searchable()
                    ->sortable(),
                Columns\Text::make('queue')
                    ->searchable()
                    ->sortable(),
                Columns\Text::make('exception')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Columns\Text::make('failed_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
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
            Pages\ListFailedJobs::routeTo('/', 'index'),
            Pages\CreateFailedJob::routeTo('/create', 'create'),
            Pages\EditFailedJob::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
