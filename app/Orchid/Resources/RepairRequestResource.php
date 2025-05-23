<?php

namespace App\Orchid\Resources;

use App\Models\Client;
use App\Models\Part;
use App\Models\Product;
use App\Models\RepairRequest;
use App\Orchid\Filters\StatusRepairFilter;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class RepairRequestResource extends Resource
{
    /**
     * Модель, с которой связан ресурс.
     */
    public static $model = RepairRequest::class;

    /**
     * Иконка ресурса в меню.
     */
    public static function icon(): string
    {
        return 'bs.basket';
    }

    /**
     * Название ресурса в интерфейсе.
     */
    public static function label(): string
    {
        return 'Заявки на ремонт';
    }

    /**
     * Подпись для кнопки создания.
     */
    public static function createButtonLabel(): string
    {
        return 'Создать новую заявку';
    }

    /**
     * Подпись для кнопки сохранения.
     */
    public static function updateButtonLabel(): string
    {
        return 'Сохранить изменения';
    }

    /**
     * Подпись для кнопки удаления.
     */
    public static function deleteButtonLabel(): string
    {
        return 'Удалить заявку';
    }

    /**
     * Поля для создания и редактирования заявки.
     */
    public function fields(): array
    {
        return [
            Select::make('product_id')
                ->fromModel(Product::class, 'name')  // Выбираем активные продукты
                ->title('Выберите продукт')
                ->required()
                ->help('Выберите активный продукт')
                ->applyScope('active'),  // Применяем scope для фильтрации

            Select::make('client_id')
                ->fromModel(Client::class, 'name')
                ->title('Выберите клиента')
                ->required()
                ->help('Выберите клиента для заявки'),

            Select::make('part_id')
                ->title('Запчасти')
                ->options(function () {
                    return Part::where('is_active', true)
                        ->get()
                        ->mapWithKeys(function ($part) {
                            $quantityText = $part->quantity > 0
                                ? "{$part->name} ({$part->quantity} шт.)"
                                : "{$part->name} (Закончились)";
                            return [$part->id => $quantityText];
                        });
                })
                ->required()
                ->help('Выберите запчасть для ремонта'),

            Select::make('status')
                ->title('Статус заявки')
                ->options([
                    'in_progress' => 'В процессе',
                    'completed' => 'Завершено',
                    'pending' => 'В ожидании',
                ])
                ->required(),

            DateTimer::make('repair_start_date')
                ->title('Дата начала ремонта')
                ->required(),

            DateTimer::make('repair_end_date')
                ->title('Дата окончания ремонта')
                ->required(),

            TextArea::make('note')
                ->title('Примечание')
                ->rows(3)
                ->placeholder('Введите примечание при необходимости'),
        ];
    }

    /**
     * Колонки для отображения заявок в таблице.
     */
    public function columns(): array
    {
        return [
            TD::make('id', 'ID')->sort(),
            TD::make('product.name', 'Продукт')
                ->render(fn($model) => $model->product?->name ?? 'Не указано'),

            TD::make('part.name', 'Запчасть')
                ->render(fn($model) => $model->part?->name ?? 'Не указано'),

            TD::make('client.name', 'Клиент')
                ->render(fn($model) => $model->client?->name ?? 'Не указано'),

            TD::make('status', 'Статус')
                ->render(fn($model) => match ($model->status) {
                    'in_progress' => '🟡 В процессе',
                    'completed' => '✅ Завершено',
                    'pending' => '⏳ В ожидании',
                }),

            TD::make('repair_start_date', 'Начало ремонта')
                ->sort()
                ->render(fn($model) => $model->repair_start_date->format('Y-m-d H:i')),

            TD::make('repair_end_date', 'Завершение ремонта')
                ->sort()
                ->render(fn($model) => $model->repair_end_date->format('Y-m-d H:i')),
        ];
    }

    /**
     * Детальный просмотр заявки.
     */

    public function legend(): array
    {
        return [
            Sight::make('product.name', 'Продукт')
                ->render(function ($repairRequest) {
                    return $repairRequest->product->name ?? 'Не выбран';
                }),

            Sight::make('part.name', 'Запчасть')
                ->render(function ($repairRequest) {
                    return $repairRequest->part->name ?? 'Не выбрана';
                }),

            Sight::make('client.name', 'Клиент')
                ->render(function ($repairRequest) {
                    return $repairRequest->client->name ?? 'Не выбран';
                }),

            Sight::make('status', 'Статус')
                ->render(function ($repairRequest) {
                    return match ($repairRequest->status) {
                        'in_progress' => '🟡 В процессе',
                        'completed' => '✅ Завершено',
                        'pending' => '⏳ В ожидании',
                    };
                }),

            Sight::make('repair_start_date', 'Дата начала ремонта')
                ->render(function ($repairRequest) {
                    return $repairRequest->repair_start_date ? $repairRequest->repair_start_date->format('d.m.Y') : 'Не указана';
                }),

            Sight::make('repair_end_date', 'Дата окончания ремонта')
                ->render(function ($repairRequest) {
                    $repairEndDate = $repairRequest->repair_end_date ? $repairRequest->repair_end_date->format('d.m.Y') : 'Не указана';

                    // Проверяем, если дата завершения ремонта просрочена
                    if ($repairRequest->repair_end_date && $repairRequest->repair_end_date->isBefore(now())) {
                        $overdueDays = $repairRequest->repair_end_date->diffInDays(now());  // Количество дней просрочки

                        // Округляем количество дней до целого числа
                        return "<span style='color: red;'>$repairEndDate (Просрочено на " . floor($overdueDays) . " дней)</span>";
                    }

                    return $repairEndDate;
                }),

            Sight::make('note', 'Примечание')
                ->render(function ($repairRequest) {
                    return $repairRequest->note ?? 'Нет примечаний';
                }),
        ];
    }
    /**
     * Фильтры для ресурса.
     */
    public function filters(): array
    {
        return [
            new StatusRepairFilter(),
        ];
    }

    public static function permission(): ?string
    {
        return 'platform.repairs';
    }
}
