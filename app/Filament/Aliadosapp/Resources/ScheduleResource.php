<?php

namespace App\Filament\Aliadosapp\Resources;

use App\Filament\Aliadosapp\Resources\ScheduleResource\Pages;
use App\Filament\Aliadosapp\Resources\ScheduleResource\RelationManagers;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Operaciones';

    public static function getLabel(): ?string
    {
        return _('Agendas profesionales');
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
                Forms\Components\Select::make('professional_id')
                    ->relationship(
                    name: 'professional',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn (Builder $query) => $query->where('user_id', auth()->id())->orderBy('name'),)
                    ->required(),
                Forms\Components\DatePicker::make('schedule_date')->minDate(now())->default(now())
                    ->required(),
                Forms\Components\TimePicker::make('start_time')->default("08:00:00")->format('H:i')
                    ->required(),
                Forms\Components\TimePicker::make('end_time')->default("12:00:00")->format('H:i')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('professional.name')
                    ->numeric()->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('schedule_date')
                    ->date()->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')->time(),
                Tables\Columns\TextColumn::make('start_time')->time(),
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
