<?php

namespace App\Filament\Aliadosapp\Resources\ProfessionalResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class ServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'services';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return _('Servicios que presta este profesional:');
    }   

    public function form(Form $form): Form
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('COP')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }
}
