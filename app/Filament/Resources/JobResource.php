<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobResource\Pages;
use App\Filament\Resources\JobResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class JobResource extends Resource
{
    public static $icon = 'heroicon-o-collection';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('trucksbook_username')
                    ->required(),
                Components\TextInput::make('trucksbook_job_id')
                    ->required()
                    ->unique('jobs', 'trucksbook_job_id', true)
                    ->numeric()
                    ->min(1),
                Components\Select::make('game')
                    ->required()
                    ->options(['ETS2' => 'ETS2', 'ATS' => 'ATS']),
                Components\TextInput::make('from')
                    ->required(),
                Components\TextInput::make('to')
                    ->required(),
                Components\TextInput::make('cargo')
                    ->required(),
                Components\TextInput::make('damage')
                    ->required()
                    ->numeric()
                    ->min(0)
                    ->max(100),
                Components\TextInput::make('xp')
                    ->required()
                    ->label('XP')
                    ->numeric()
                    ->min(0),
                Components\TextInput::make('profit')
                    ->required()
                    ->numeric()
                    ->min(0),
                Components\TextInput::make('planned_distance')
                    ->required()
                    ->numeric()
                    ->min(0),
                Components\TextInput::make('driven_distance')
                    ->required()
                    ->numeric()
                    ->min(0),
                Components\TextInput::make('weight')
                    ->required()
                    ->numeric()
                    ->min(0),
                Components\Textarea::make('description')
                    ->nullable(),
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
                Columns\Text::make('trucksbook_username')
                    ->searchable()
                    ->sortable(),
                Columns\Text::make('trucksbook_job_id')
                    ->url(fn($job) => "https://trucksbook.eu/delivery/{$job->trucksbook_job_id}", true)
                    ->searchable()
                    ->sortable(),
                Columns\Text::make('game')
                    ->searchable()
                    ->sortable(),
                Columns\Text::make('from')
                    ->searchable()
                    ->sortable(),
                Columns\Text::make('to')
                    ->searchable()
                    ->sortable(),
                Columns\Text::make('cargo')
                    ->searchable()
                    ->sortable(),
                Columns\Text::make('damage')
                    ->sortable(),
                Columns\Text::make('xp')
                    ->sortable(),
                Columns\Text::make('profit')
                    ->sortable(),
                Columns\Text::make('planned_distance')
                    ->sortable(),
                Columns\Text::make('driven_distance')
                    ->sortable(),
                Columns\Text::make('weight')
                    ->sortable(),
                Columns\Text::make('description')
                    ->searchable(),
                Columns\Text::make('created_at')
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
            Pages\ListJobs::routeTo('/', 'index'),
            Pages\CreateJob::routeTo('/create', 'create'),
            Pages\EditJob::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
