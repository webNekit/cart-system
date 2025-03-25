<?php

namespace App\Orchid\Resources;

use App\Models\Product;
use App\Models\TypeProduct;
use App\Orchid\Filters\ProductFilter;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class ProductResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Product::class;

    public static function icon(): string
    {
        return 'bs.basket'; // Здесь укажи нужный класс иконки
    }

    public static function label(): string
    {
        return 'Тележки';
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
            Input::make('name')
                ->title('Название')
                ->placeholder('Введите название')
                ->required(),
            Input::make('sku')
                ->title('Артикул')
                ->placeholder('Введите артикул')
                ->required(),

            Input::make('capacity')
                ->title('Грузоподъемность (кг)')
                ->type('number')
                ->required(),

            Input::make('drive')
                ->title('Привод')
                ->placeholder('Ручной/Электрический')
                ->required(),

            Input::make('construction')
                ->title('Конструкция')
                ->placeholder('Тип конструкции')
                ->required(),

            Select::make('type_product_id')
                ->title('Тип тележки')
                ->options(TypeProduct::where('is_active', true)->pluck('name', 'id'))
                ->required(),

            CheckBox::make('is_active')
                ->title('Активный продукт')
                ->sendTrueOrFalse(),

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
            TD::make('name', 'Название'),
            TD::make('sku', 'Артикул'),
            TD::make('is_active', 'Активность')
                ->render(fn(Product $product) => $product->is_active
                    ? '✅ Активен'
                    : '❌ Неактивен'),
            TD::make('type_product_id', 'Тип тележки')
                ->render(fn(Product $product) => $product->typeProduct->name),
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
            Sight::make('name', 'Название'),
            Sight::make('sku', 'Артикул'),
            Sight::make('capacity', 'Грузоподъемность'),
            Sight::make('drive', 'Привод'),
            Sight::make('construction', 'Конструкция'),
            Sight::make('is_active', 'Активность')
                ->render(fn($model) => $model->is_active ? 'Активен' : 'Не активен'),
            Sight::make('parts', 'Связанные запчасти')
                ->render(fn(Product $product) =>
                $product->parts->map(fn($part) => "{$part->name} ({$part->quantity} шт.)")->join(', ') ?: 'Нет запчастей'),
            Sight::make('type_product_id', 'Тип тележки')
                ->render(fn($model) => $model->typeProduct->name ?? 'Не задано'),
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
            new ProductFilter(),
        ];
    }
}
