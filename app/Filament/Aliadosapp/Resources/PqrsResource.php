<?php

namespace App\Filament\Aliadosapp\Resources;

use App\Filament\Aliadosapp\Resources\PqrsResource\Pages;
use App\Filament\Aliadosapp\Resources\PqrsResource\RelationManagers;
use App\Models\Pqrs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PqrsResource extends Resource
{
    protected static ?string $model = Pqrs::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';
    protected static ?string $navigationGroup = 'Gestión PQRS';

    public static function getLabel(): ?string
    {
        return _('PQRS');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->forLoggedUser();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship(
                        name: 'user',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('id', auth()->id())->orderBy('name'),)->default(auth()->id())
                    ->required(),
                Forms\Components\Select::make('target_user_id')
                    ->relationship('targetUser', 'name')
                    ->required(),
                Forms\Components\Radio::make('type')
                    ->options([
                        'Petición' => 'Petición',
                        'Queja' => 'Queja',
                        'Reclamo' => 'Reclamo',
                        'Sugerencia' => 'Sugerencia'
                    ])->default('Petición')->inline(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('targetUser.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
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
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\MessagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPqrs::route('/'),
            'create' => Pages\CreatePqrs::route('/create'),
            'edit' => Pages\EditPqrs::route('/{record}/edit'),
        ];
    }
}
