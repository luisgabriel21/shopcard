<?php

namespace App\Filament\Aliadosapp\Resources;

use App\Filament\Aliadosapp\Resources\CampaignResource\Pages;
use App\Models\Affiliate;
use App\Models\Campaign;
use App\Models\User;
use App\Notifications\SystemStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Notifications\Notification;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Marketing';

    public static function getLabel(): ?string
    {
        return _('Campañas');
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
                Forms\Components\Select::make('service_id')
                ->relationship(
                    name: 'service',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn (Builder $query) => $query->where('user_id', auth()->id())->orderBy('name'),)
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\RichEditor::make('description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                CuratorPicker::make('image')
                    ->color('success') // defaults to primary
                    ->size('sm'),
                Forms\Components\DateTimePicker::make('start_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                CuratorColumn::make('image')->size(40),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
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
                Tables\Actions\Action::make('Notificar usuarios')
                    ->form([
                        CheckboxList::make('affiliates')
                                ->label('Afiliados')
                                ->options(User::all()->where('role_id', 3)->pluck('name', 'id'))
                                ->searchable()
                                ->searchPrompt('Buscar afiliados para enviar el correo')
                                ->bulkToggleable()
                                ->columns(4)
                                ->gridDirection('row')
                                
                                

                    ])
                    ->action( 
                        function (array $data) {
                            foreach ($data['affiliates'] as $affiliateId) 
                                User::find($affiliateId)->notify
                                    (new SystemStatus('Hay una nueva campaña promocial!', 
                                    'Hola te contactamos para contarte que hay una nueva campaña promocial, 
                                     entra al sistema para ver los detalles'));

                                $recipient = collect([Affiliate::find($affiliateId)]);
                                Notification::make()
                                    ->title(title:'Hay una nueva campaña promocional:')
                                    ->success()
                                    ->icon('heroicon-m-gift')
                                    ->body( 
                                    '<p>- Hay una nueva campaña promocial, dale una mirada desde el menú campañas</p>')
                                    ->sendToDatabase($recipient); 
                        }
                    )->icon('heroicon-o-envelope'),
                    
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
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}
