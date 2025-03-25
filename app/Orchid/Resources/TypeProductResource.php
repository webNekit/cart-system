<?php

namespace App\Orchid\Resources;

use App\Models\TypeProduct;
use App\Orchid\Filters\TypeProductFilter;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\TD;

class TypeProductResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = TypeProduct::class;

    public static function icon(): string
    {
        return 'bs.puzzle'; // Здесь укажи нужный класс иконки
    }

    public static function label(): string
    {
        return 'Типы тележек';
    }

    public static function createButtonLabel(): string
    {
        return 'Добавить';
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
                ->required()
                ->title(__('Тип тележки'))
                ->placeholder(__('Со стандартными вилами')),
            CheckBox::make('is_active')
                ->sendTrueOrFalse()
                ->title(__('Отображать в системе'))
                ->default(1),
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
            TD::make('id'),
            TD::make('name'),
            TD::make('is_active', 'Статус')
                ->render(
                    fn(TypeProduct $type) => $type->is_active
                        ? '<span style="color:green;">✅ Активный</span>'
                        : '<span style="color:red;">❌ Неактивный</span>'
                ),
            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            TD::make('updated_at', 'Update date')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                }),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            new TypeProductFilter(),
        ];
    }
}
