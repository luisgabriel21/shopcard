<?php

namespace App\Filament\Aliadosapp\Resources;


use App\Filament\Aliadosapp\Resources\AppointmentResource\Pages;
use App\Filament\Aliadosapp\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use App\Models\Professional_Services;
use App\Models\Role;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Form;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Split;
use Filament\Support\Enums\FontWeight;

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
                    ->required()->columnSpanFull(),
                Forms\Components\Select::make('affiliate_id')
                    ->relationship( 
                        name: 'afilliate',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('role_id', Role::AFFILIATE)->orderBy('name'),)
                        ->searchable()->preload()->required(),
                Forms\Components\Select::make('service_id')
                        ->relationship( name: 'service', 
                                        titleAttribute: 'name',
                                        modifyQueryUsing: 
                                            fn (Builder $query) => 
                                                $query->where('user_id', auth()->id())->orderBy('name'))
                    ->preload()->live()->reactive()->afterStateUpdated(function (callable $set) {$set('professional_id', null);})->required(),
                Forms\Components\Select::make('professional_id')
                                    ->options(
                                        function (callable $get) { 
                                            return Professional_Services::query()->join('professionals', 'professionals.id', '=', 'professional_services.professional_id')
                                            ->where('professional_services.service_id', $get('service_id'))
                                            ->where('professionals.user_id', auth()->id())
                                            ->pluck('professionals.name', 'professionals.id');
                                        }
                                    )
                    ->reactive()->live()->afterStateUpdated(function (callable $set) {$set('Agenda', null);})->required(),
                    CheckboxList::make('Agenda')
                               ->options(
                                function (callable $get) { 
                                    return Schedule::query()
                                                            ->join('professionals', 'professionals.id', '=', 'schedules.professional_id')
                                                            ->where('professionals.id', $get('professional_id') )
                                                            ->where('professionals.user_id', auth()->id())
                                                            ->where('schedules.schedule_date','>=', now() )
                                                            ->orderBy('schedules.schedule_date', 'asc')
                                                            ->limit(3)
                                                            ->pluck('schedules.schedule_date', 'schedules.id')
                                                            ;
                                }
                                )
                                ->descriptions(
                                    function (callable $get) { 
                                                            return Schedule::query()->select("schedules.id", 
                                                            DB::raw("CONCAT('Desde: ',schedules.start_time,' hasta: ',schedules.end_time) as full_name"),
                                                            "schedules.schedule_date")
                                                                ->join('professionals', 'professionals.id', '=', 'schedules.professional_id')
                                                                ->where('professionals.id', $get('professional_id') )
                                                                ->where('professionals.user_id', auth()->id())
                                                                ->where('schedules.schedule_date','>=', now() )
                                                                ->orderBy('schedules.schedule_date', 'asc')
                                                                ->limit(4)
                                                                ->pluck('full_name', 'schedules.id')
                                                                ;
                                    }
                                )
                                ->visible(static fn (callable $get) => $get('professional_id'))->reactive()->live()->disabled()->columns(2),
                Forms\Components\DateTimePicker::make('appointment_datetime')->minDate(date_create('-1 day')->format('Y-m-d H:i:s'))->default(now())
                    ->required(),
                Forms\Components\Radio::make('status')
                    ->options([
                        'Solicitada' => 'Solicitada',
                        'Aprobada' => 'Aprobada',
                        'Cancelada' => 'Cancelada',
                    ])->default('Solicitada')->inline()->columnSpanFull(),
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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Solicitada' => 'Solicitada',
                        'Aprobada' => 'Aprobada',
                        'Cancelada' => 'Cancelada',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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


public static function infolist(Infolist $infolist): Infolist
{
    return $infolist->schema([
            Grid::make([
                'default' => 1,
                'sm' => 2,
                'md' => 3,
                'lg' => 4,
                'xl' => 6,
                '2xl' => 8,
            ])    
            ->schema([
                Section::make('Profesional')
                    ->description('Profesional a cargo de la cita:')
                    ->icon('heroicon-m-user-group')
                    ->schema([
                        Split::make([
                            Section::make([
                                ImageEntry::make('professional.image')->hiddenLabel(),
                                TextEntry::make('professional.name')
                                    ->hiddenLabel()
                                    ->size(TextEntry\TextEntrySize::Large)
                                    ->weight(FontWeight::Bold),
                                        
                            ])->columns(1),
                            Section::make([
                                
                                TextEntry::make('professional.phone_number')->hiddenLabel()->icon('heroicon-m-phone')->iconColor('primary'),
                                TextEntry::make('professional.email')->hiddenLabel()->icon('heroicon-m-envelope')->iconColor('primary'),
                                TextEntry::make('professional.description')->hiddenLabel()->columnSpan(2),
                            ])->grow(false),
                            ])->from('md'),
                        ])
                    ])->columnSpanFull()->grow(),
                    Section::make('Cita')
                    ->description('Datos de la cita:')
                    ->icon('heroicon-m-calendar-days')
                    ->schema([
                        Split::make([
                            TextEntry::make('appointment_datetime')->label('Fecha:')->badge()->color('danger')->columnSpan(2),
                            TextEntry::make('status')->label('Estado:')->badge()->color('success')->columnSpan(2),
                        ])
                    ]),
                    Split::make([
                            Section::make('Servicio:')->icon('heroicon-m-clipboard-document-list')->schema([
                                TextEntry::make('service.name')
                                    ->hiddenLabel()                                    
                                    ->size(TextEntry\TextEntrySize::Large)
                                    ->weight(FontWeight::Bold),
                                TextEntry::make('service.category')->hiddenLabel(),
                                TextEntry::make('service.price')->hiddenLabel()->icon('heroicon-m-currency-dollar')->iconColor('primary')->badge()->color('success'),
                                TextEntry::make('service.description')->hiddenLabel()->columnSpan(3),
                            ])->grow(false),
                            Section::make('Afiliado:')->icon('heroicon-m-user-circle')->schema([
                                TextEntry::make('afilliate.name')->hiddenLabel()->columnSpan(2)
                                    ->size(TextEntry\TextEntrySize::Large)
                                    ->weight(FontWeight::Bold),
                                TextEntry::make('afilliate.email')->hiddenLabel()->columnSpan(2)->icon('heroicon-m-envelope')
                                ->iconColor('primary'),

                             ])->grow(false),
                             ])->columnSpanFull()->grow(),
                    
        ]);
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
