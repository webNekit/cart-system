<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class TypeProductFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Фильтр по статусу';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['status'];
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
        $status = $this->request->get('status');
        if ($status === 'active') {
            return $builder->where('is_active', true);
        }
        if ($status === 'inactive') {
            return $builder->where('is_active', false);
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
            Select::make('status')->options([
                '' => 'Все типы',
                'active' => 'Только активные',
                'inactive' => 'Только неактивные',
            ])
                ->title(__('Фильтр по статусу'))
                ->empty(__('Выберите статус')),
        ];
    }
}
