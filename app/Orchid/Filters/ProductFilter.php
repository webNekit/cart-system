<?php

namespace App\Orchid\Filters;

use App\Models\TypeProduct;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class ProductFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Фильтр';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        $isActive = $this->request->get('is_active');
        $typeProductId = $this->request->get('type_product_id');

        // Фильтрация по активности (не применяем, если выбрано "all" или не установлено значение)
        if ($isActive !== null && $isActive !== 'all') {
            $builder->where('is_active', $isActive);
        }

        // Фильтрация по типу тележки (если значение установлено)
        if (!empty($typeProductId)) {
            $builder->where('type_product_id', $typeProductId);
        }

        return $builder;
    }


    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make('is_active')
                ->title('Активность')
                ->options([
                    'all' => 'Все',
                    '1' => 'Активные',
                    '0' => 'Неактивные',
                ])
                ->empty('Выберите активность', 'all'),
            Select::make('type_product_id')
                ->title('Тип тележки')
                ->fromModel(TypeProduct::where('is_active', 'on'), 'name')
                ->empty('Выберите тип'),
        ];
    }
}
