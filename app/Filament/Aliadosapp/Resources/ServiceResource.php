<?php

namespace App\Filament\Aliadosapp\Resources;

use App\Filament\Aliadosapp\Resources\ServiceResource\Pages;
use App\Filament\Aliadosapp\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Operaciones';
    
    public static function getLabel(): ?string
    {
        return _('Servicios');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->forLoggedUser();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')->default(auth()->id()),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category')
                    ->required()
                    ->options ([
                        'Otros' => 'Otros',
                        'Servicios Médicos' => 'Servicios Médicos',
                        'Servicios Estéticos' => 'Servicios Estéticos',
                        'Servicios Odontológicos' => 'Servicios Odontológicos',
                        'Dermatología' => 'Dermatología',
                        'Cirugía Plástica' => 'Cirugía Plástica',
                        'Ginecología' => 'Ginecología',
                        'Oftalmología' => 'Oftalmología',
                        'Nutrición y Dietética' => 'Nutrición y Dietética',
                        'Fisioterapia' => 'Fisioterapia',
                        'Psicología' => 'Psicología',
                        'Radiología' => 'Radiología',
                        'Pedicura' => 'Pedicura',
                        'Masajes reductores' => 'Masajes reductores',
                        'Tratamientos Capilares' => 'Tratamientos Capilares',
                        'Podología' => 'Podología',
                        'Bronceado' => 'Bronceado',
                        // ... Agrega más categorías según tus necesidades
                    ])->native(false)->searchable(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('COP')
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
                Tables\Filters\SelectFilter::make('category')
                ->options ([
                    'Otros' => 'Otros',
                    'Servicios Médicos' => 'Servicios Médicos',
                    'Servicios Estéticos' => 'Servicios Estéticos',
                    'Servicios Odontológicos' => 'Servicios Odontológicos',
                    'Dermatología' => 'Dermatología',
                    'Cirugía Plástica' => 'Cirugía Plástica',
                    'Ginecología' => 'Ginecología',
                    'Oftalmología' => 'Oftalmología',
                    'Nutrición y Dietética' => 'Nutrición y Dietética',
                    'Fisioterapia' => 'Fisioterapia',
                    'Psicología' => 'Psicología',
                    'Radiología' => 'Radiología',
                    'Pedicura' => 'Pedicura',
                    'Masajes reductores' => 'Masajes reductores',
                    'Tratamientos Capilares' => 'Tratamientos Capilares',
                    'Podología' => 'Podología',
                    'Bronceado' => 'Bronceado',
                    // ... Agrega más categorías según tus necesidades
                ])->native(false)->searchable()
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
            ServiceResource\RelationManagers\ProfessionalsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ServiceResource\Widgets\ServiceStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
