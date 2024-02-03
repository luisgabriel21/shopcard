<?php

namespace App\Filament\Aliadosapp\Resources;

use App\Filament\Aliadosapp\Resources\ServiceResource\Pages;
use App\Filament\Aliadosapp\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
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
                        'otros' => 'Otros',
                        'medicos' => 'Servicios Médicos',
                        'esteticos' => 'Servicios Estéticos',
                        'odontologicos' => 'Servicios Odontológicos',
                        'dermatologia' => 'Dermatología',
                        'cirugia_plastica' => 'Cirugía Plástica',
                        'ginecologia' => 'Ginecología',
                        'oftalmologia' => 'Oftalmología',
                        'nutricion' => 'Nutrición y Dietética',
                        'fisioterapia' => 'Fisioterapia',
                        'psicologia' => 'Psicología',
                        'radiologia' => 'Radiología',
                        'pedicura' => 'Pedicura',
                        'corte_cabello' => 'Corte de Cabello',
                        'manicura' => 'Manicura',
                        'depilacion' => 'Depilación',
                        'maquillaje' => 'Maquillaje',
                        'masajes' => 'Masajes',
                        'tratamientos_capilares' => 'Tratamientos Capilares',
                        'podologia' => 'Podología',
                        'bronceado' => 'Bronceado',
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
