<?php

namespace App\Filament\Aliadosapp\Resources\PqrsResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return _('Mensajes de la PQRS:');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sender_id')
                ->relationship(
                    name: 'sender',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn (Builder $query) => $query->where('id', auth()->id())->orderBy('name'),)
                ->required()->default(auth()->id()),
                Forms\Components\TextInput::make('message')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message')
            ->columns([
                Tables\Columns\TextColumn::make('message'),
                Tables\Columns\TextColumn::make('sender.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                    
            ])
            ->actions([

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([

                ]),
            ]);
    }
}
