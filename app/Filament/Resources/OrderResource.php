<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatusType;
use App\Filament\Resources\OrderResource\Pages;
use App\Helpers\MoneyHelper;
use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Orders';

    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.first_name')
                    ->searchable()
                    ->label('First Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.last_name')
                    ->searchable()
                    ->label('Last Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->label('Address'),
                Tables\Columns\TextColumn::make('price')
                    ->money('usd')
                    ->sortable()
                    ->prefix('$')
                    ->formatStateUsing(fn(int $state): float => MoneyHelper::toDecimal($state)),
                Tables\Columns\BadgeColumn::make('status')
                    ->color(fn(OrderStatusType $state): string => match ($state) {
                        OrderStatusType::New => 'danger',
                        OrderStatusType::Processing => 'warning',
                        OrderStatusType::Completed => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        OrderStatusType::New->value => 'New',
                        OrderStatusType::Processing->value => 'Processing',
                        OrderStatusType::Completed->value => 'Completed',
                    ]),
            ])
            ->actions([
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}