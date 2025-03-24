<?php

namespace App\Orchid\Filters;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class PartFilter extends Filter
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
        $productId = $this->request->get('product_id');

        if ($isActive !== 'all' && $isActive !== null) {
            $builder->where('is_active', $isActive);
        }

        if (!empty($productId)) {
            $builder->where('product_id', $productId);
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

            Select::make('product_id')
                ->title('Продукт')
                ->fromModel(Product::class, 'name')
                ->empty('Выберите продукт'),
        ];
    }
}
