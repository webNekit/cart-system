<?php

namespace App\Orchid\Resources;

use App\Models\Product;
use App\Orchid\Filters\PartFilter;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class PartResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Part::class;

    public static function icon(): string
    {
        return 'bs.wrench'; // Здесь укажи нужный класс иконки
    }

    public static function label(): string
    {
        return 'Запчасти';
    }

    public static function createButtonLabel(): string
    {
        return 'Создать новую запись';
    }

    public static function updateButtonLabel(): string
    {
        return 'Сохранить';
    }


    public static function deleteButtonLabel(): string
    {
        return 'Удалить';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Select::make('product_id')
                ->title('Продукт')
                ->options(Product::where('is_active', 1)->pluck('name', 'id'))
                ->required()
                ->help('Выберите продукт, к которому относится запчасть'),

            Input::make('name')
                ->title('Название запчасти')
                ->required()
                ->placeholder('Название запчасти'),

            Input::make('quantity')
                ->title('Количество')
                ->type('number')
                ->min(0)
                ->value(0),

            CheckBox::make('is_active')
                ->title('Активна')
                ->sendTrueOrFalse()
                ->placeholder('Отображать запчасть'),
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id', 'ID')->sort(),
            TD::make('name', 'Название')->sort(),
            TD::make('quantity', 'Количество')->sort(),
            TD::make('is_active', 'Активна')
                ->render(fn($part) => $part->is_active ? 'Да' : 'Нет')
                ->sort(),
            TD::make('product_id', 'Продукт')
                ->render(fn($part) => $part->product->name ?? 'Не задан')
                ->sort(),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('id', 'ID'),
            Sight::make('name', 'Название'),
            Sight::make('quantity', 'Количество'),
            Sight::make('is_active', 'Активна')
                ->render(fn($part) => $part->is_active ? 'Да' : 'Нет'),
            Sight::make('product_id', 'Продукт')
                ->render(fn($part) => $part->product->name ?? 'Не задан'),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            new PartFilter(),
        ];
    }

    public static function permission(): ?string
    {
        return 'platform.parts';
    }
}
