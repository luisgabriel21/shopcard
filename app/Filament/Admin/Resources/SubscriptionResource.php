<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SubscriptionResource\Pages;
use App\Models\Role;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'Aliados y Afiliados';

    public static function getLabel(): ?string
    {
        return _('Suscripciones');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                  ->relationship(
                        name: 'user',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('role_id', Role::AFFILIATE)->orderBy('name'),
                    )
                    ->required(),
                Forms\Components\Select::make('plan_id')
                    ->relationship('plan', 'name')
                    ->required(),
                Forms\Components\DateTimePicker::make('start_date')
                    ->required()->default(now()),
                Forms\Components\DateTimePicker::make('end_date')
                    ->required(),
                Forms\Components\Radio::make('status')
                    ->options([
                        'Activa' => 'Activa',
                        'Cancelada' => 'Cancelada',
                        'Pausada' => 'Pausada'
                    ])->default('Activa'),
                Forms\Components\Radio::make('payment_method')
                    ->options([
                        'Efectivo' => 'Efectivo',
                        'Transferencia bancaria' => 'Transferencia bancaria',
                        'Datafono' => 'Datafono'
                    ])->default('Efectivo'),
                Forms\Components\Toggle::make('is_active')
                    ->required()->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('plan.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('payment_method')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
