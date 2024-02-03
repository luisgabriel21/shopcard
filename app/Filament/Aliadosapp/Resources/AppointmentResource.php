<?php

namespace App\Filament\Aliadosapp\Resources;

use App\Filament\Afiliadosapp\Resources\AppointmentResource as ResourcesAppointmentResource;
use App\Filament\Aliadosapp\Resources\AppointmentResource\Pages;
use App\Filament\Aliadosapp\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Citas';

    public static function getLabel(): ?string
    {
        return _('Citas');
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
                Forms\Components\Select::make('affiliate_id')
                    ->relationship( 
                        name: 'afilliate',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('role_id', Role::AFFILIATE)->orderBy('name'),)
                    ->searchable()->required(),
                Forms\Components\Select::make('professional_id')
                    ->relationship('professional', 'name')->required(),
                Forms\Components\Select::make('service_id')
                    ->relationship('service', 'name')->required(),
                Forms\Components\DateTimePicker::make('appointment_datetime')
                    ->required()->columnSpanFull(),
                Forms\Components\Radio::make('status')
                    ->options([
                        'Solicitada' => 'Solicitada',
                        'Aprobada' => 'Aprobada',
                        'Cancelada' => 'Cancelada',
                    ])->default('Petición')->inline()->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('afilliate.name')
                    ->numeric()->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('professional.name')
                    ->numeric()->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('service.name')
                    ->numeric()->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('appointment_datetime')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
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
                RelationManagers\MessagesRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            AppointmentResource\Widgets\AppointmenStatusOverview::class,
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
