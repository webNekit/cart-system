<?php

namespace App\Orchid\Resources;

use App\Models\Part;
use App\Models\Product;
use App\Models\RepairRequest;
use Illuminate\Support\Facades\Auth;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use App\Orchid\Filters\StatusRepairFilter;

class RepairRequestResource extends Resource
{
    public static $model = RepairRequest::class;

    public static function icon(): string
    {
        return 'bs.basket';
    }

    public static function label(): string
    {
        return 'Заявки на ремонт';
    }

    public static function createButtonLabel(): string
    {
        return 'Создать новую заявку';
    }

    public static function updateButtonLabel(): string
    {
        return 'Сохранить изменения';
    }

    public static function deleteButtonLabel(): string
    {
        return 'Удалить заявку';
    }

    public static function permission(): ?string
    {
        return 'platform.repairs';
    }

    public function with(): array
    {
        return ['product', 'part', 'user'];
    }

    public function fields(): array
    {
        $user = Auth::user();

        if ($user->inRole('user')) {
            return [
                Input::make('user_id')->type('hidden')->value($user->id)->hidden(),

                Select::make('product_id')
                    ->fromModel(Product::class, 'name')
                    ->title('Выберите продукт')
                    ->required()
                    ->applyScope('active'),

                TextArea::make('note')
                    ->title('Примечание')
                    ->rows(3)
                    ->placeholder('Введите примечание при необходимости'),
            ];
        }

        return [
            Input::make('user.name')->disabled()->title('Клиент'),

            Select::make('product_id')
                ->fromModel(Product::class, 'name')
                ->title('Продукт')
                ->required()
                ->disabled()
                ->applyScope('active'),

            Select::make('part_id')
                ->title('Запчасть')
                ->options(function () {
                    return Part::where('is_active', true)
                        ->get()
                        ->mapWithKeys(function ($part) {
                            $label = $part->quantity > 0
                                ? "{$part->name} ({$part->quantity} шт.)"
                                : "{$part->name} (Закончились)";
                            return [$part->id => $label];
                        });
                })
                ->required(),

            Select::make('status')
                ->title('Статус')
                ->options([
                    'in_progress' => '🟡 В процессе',
                    'completed' => '✅ Завершено',
                    'pending' => '⏳ В ожидании',
                ])
                ->required(),

            Input::make('price')
                ->title('Цена ремонта')
                ->type('number')
                ->step(0.01)
                ->placeholder('Введите цену в рублях'),

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

    public function columns(): array
    {
        return [
            TD::make('id', 'ID')->sort(),

            TD::make('product.name', 'Продукт')
                ->render(fn($model) => $model->product?->name ?? 'Не указано'),

            TD::make('part.name', 'Запчасть')
                ->render(fn($model) => $model->part?->name ?? 'Не указано'),

            TD::make('user.name', 'Заказчик')
                ->render(fn($model) => $model->user?->name ?? 'Не указан'),

            TD::make('status', 'Статус')
                ->render(fn($model) => match ($model->status) {
                    'in_progress' => '🟡 В процессе',
                    'completed' => '✅ Завершено',
                    'pending' => '⏳ В ожидании',
                }),

            TD::make('price', 'Цена')
                ->render(fn($model) => $model->price ? number_format($model->price, 2) . ' ₽' : '—'),

            TD::make('repair_start_date', 'Начало ремонта')
                ->render(fn($model) => optional($model->repair_start_date)->format('Y-m-d')),

            TD::make('repair_end_date', 'Окончание ремонта')
                ->render(fn($model) => optional($model->repair_end_date)->format('Y-m-d')),
        ];
    }

    public function legend(): array
    {
        return [
            Sight::make('product.name', 'Продукт'),
            Sight::make('part.name', 'Запчасть'),
            Sight::make('user.name', 'Клиент'),

            Sight::make('status', 'Статус')
                ->render(fn($req) => match ($req->status) {
                    'in_progress' => '🟡 В процессе',
                    'completed' => '✅ Завершено',
                    'pending' => '⏳ В ожидании',
                }),

            Sight::make('price', 'Цена ремонта')
                ->render(fn($req) => $req->price ? number_format($req->price, 2) . ' ₽' : '—'),

            Sight::make('repair_start_date', 'Дата начала ремонта')
                ->render(fn($req) => optional($req->repair_start_date)->format('d.m.Y')),

            Sight::make('repair_end_date', 'Дата окончания ремонта')
                ->render(function ($req) {
                    $date = optional($req->repair_end_date)->format('d.m.Y');
                    if ($req->repair_end_date && $req->repair_end_date->isPast()) {
                        $overdue = $req->repair_end_date->diffInDays(now());
                        return "<span style='color:red;'>$date (Просрочено на $overdue дней)</span>";
                    }
                    return $date;
                }),

            Sight::make('note', 'Примечание'),
        ];
    }

    public function filters(): array
    {
        return [
            new StatusRepairFilter(),
        ];
    }

    public function onSave($request, $model)
    {
        if (Auth::user()->inRole('user')) {
            $model->user_id = Auth::id();
        }

        $model->fill($request->all())->save();
    }

    public function canCreate(): bool
    {
        return Auth::user()->inRole('user');
    }
}
