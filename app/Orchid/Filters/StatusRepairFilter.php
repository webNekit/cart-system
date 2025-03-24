<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Field;

class StatusRepairFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Статус заявки';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['status'];  // Параметр для фильтрации по статусу
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
        // Если статус передан через параметр, фильтруем по статусу
        if ($status = $this->request->get('status')) {
            return $builder->where('status', $status);
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
            Select::make('status')  // Выпадающий список для выбора статуса
                ->title('Фильтр по статусу')
                ->options([
                    '' => 'Все статусы',  // Пустое значение для всех статусов
                    'in_progress' => 'В процессе',
                    'completed' => 'Завершено',
                    'pending' => 'В ожидании',
                ])
                ->value(request()->get('status')),  // Устанавливаем выбранное значение фильтра
        ];
    }
}
