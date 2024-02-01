<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PqrsmessageResource\Pages;
use App\Filament\Admin\Resources\PqrsmessageResource\RelationManagers;
use App\Models\Pqrsmessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PqrsmessageResource extends Resource
{
    protected static ?string $model = Pqrsmessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';
    protected static ?string $navigationGroup = 'Gestión PQRS';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pqrs_id')
                    ->relationship('pqrs', 'id')
                    ->required(),
                Forms\Components\Select::make('sender_id')
                    ->relationship('sender', 'name')
                    ->required(),
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pqrs.id')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListPqrsmessages::route('/'),
            'create' => Pages\CreatePqrsmessage::route('/create'),
            'edit' => Pages\EditPqrsmessage::route('/{record}/edit'),
        ];
    }
}
