<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\OrderDeliveryMethodType;
use App\Enums\OrderPaymentMethodType;
use App\Enums\OrderStatusType;
use App\Filament\Resources\OrderResource;
use App\Helpers\MoneyHelper;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Order Status')
                    ->schema([
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn(OrderStatusType $state): string => match ($state) {
                                OrderStatusType::New => 'danger',
                                OrderStatusType::Processing => 'warning',
                                OrderStatusType::Completed => 'success',
                            })
                            ->weight(FontWeight::Bold)
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large),
                    ])
                    ->columnSpan(1),

                Infolists\Components\Section::make('Customer Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('customer.first_name')
                            ->label('First name')
                            ->weight(FontWeight::Bold),
                        Infolists\Components\TextEntry::make('customer.last_name')
                            ->label('Last name')
                            ->weight(FontWeight::Bold),
                        Infolists\Components\TextEntry::make('customer.email')
                            ->label('Email')
                            ->icon('heroicon-m-envelope'),
                        Infolists\Components\TextEntry::make('customer.phone')
                            ->label('Phone')
                            ->icon('heroicon-m-phone'),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Order Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('price')
                            ->money('usd')
                            ->prefix('$')
                            ->weight(FontWeight::Bold)
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->formatStateUsing(fn(int $state): float => MoneyHelper::toDecimal($state)),
                        Infolists\Components\TextEntry::make('delivery_method')
                            ->badge()
                            ->label('Delivery method')
                            ->formatStateUsing(fn(OrderDeliveryMethodType $state): string => match ($state) {
                                OrderDeliveryMethodType::Pickup => 'Pickup method',
                                OrderDeliveryMethodType::Post => 'Post method',
                            })
                            ->icon('heroicon-m-truck'),
                        Infolists\Components\TextEntry::make('payment_method')
                            ->badge()
                            ->label('Payment method')
                            ->formatStateUsing(fn(OrderPaymentMethodType $state): string => match ($state) {
                                OrderPaymentMethodType::Online => 'Online method',
                                OrderPaymentMethodType::Postpaid => 'Post Paid method',
                            })
                            ->icon('heroicon-m-credit-card'),
                        Infolists\Components\TextEntry::make('address')
                            ->label('Address'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime()
                            ->icon('heroicon-m-calendar'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make()
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('orderItems')
                            ->schema([
                                Infolists\Components\TextEntry::make('product.name')
                                    ->label('Product')
                                    ->weight(FontWeight::Bold),
                                Infolists\Components\TextEntry::make('amount')
                                    ->label('Quantity')
                                    ->badge(),
                                Infolists\Components\TextEntry::make('product_price')
                                    ->label('Product Price')
                                    ->money('usd')
                                    ->prefix('$')
                                    ->formatStateUsing(fn(int $state) => MoneyHelper::toDecimal($state)),
                                Infolists\Components\TextEntry::make('total_price')
                                    ->label('Total')
                                    ->money('usd')
                                    ->prefix('$')
                                    ->formatStateUsing(
                                        fn($state) => MoneyHelper::toDecimal($state)
                                    )
                                    ->weight(FontWeight::Bold),
                            ])
                            ->columns(4),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('updateStatus')
                ->label('Update Status')
                ->icon('heroicon-m-arrow-path')
                ->form([
                    Forms\Components\Select::make('status')
                        ->options([
                            OrderStatusType::New->value => 'New',
                            OrderStatusType::Processing->value => 'Processing',
                            OrderStatusType::Completed->value => 'Completed',
                        ])
                        ->required()
                        ->default(fn($record) => $record->status),
                ])
                ->action(function (array $data, $livewire): void {
                    $this->record->update(['status' => $data['status']]);
                    $livewire->redirect(request()->header('Referer'));
                })
                ->requiresConfirmation()
                ->modalHeading('Update Order Status')
                ->modalDescription(
                    'Are you sure you want to update the status of this order? This action cannot be undone.'
                )
                ->modalSubmitActionLabel('Yes, update status')
                ->color('warning'),
        ];
    }
} 