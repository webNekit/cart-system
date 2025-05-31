<?php

namespace App\Orchid\Resources;

use App\Models\Product;
use Illuminate\Support\Str;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class UserRepairRequestResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\UserRepairRequest::class;

    public static function label(): string
    {
        return 'Мои заявки';
    }

    public static function icon(): string
    {
        return 'bs.file-earmark-text';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('user_id')->value(auth()->id())->hidden(),

            Select::make('product_id')
                ->fromModel(Product::class, 'name')
                ->title('Выберите рохлю')
                ->required(),

            TextArea::make('note')
                ->title('Примечание')
                ->rows(3),

            Select::make('status')
                ->title('Статус')
                ->options([
                    'pending' => '⏳ В ожидании',
                    'in_progress' => '🟡 В процессе',
                    'completed' => '✅ Завершено',
                ])
                ->disabled(), // Только для отображения
        ];
    }

    public function columns(): array
    {
        return [
            TD::make('id', 'ID')->sort(),

            TD::make('product.name', 'Продукт')
                ->render(fn($model) => $model->product?->name ?? '—'),

            TD::make('status', 'Статус')
                ->render(fn($model) => match($model->status) {
                    'pending' => '⏳ В ожидании',
                    'in_progress' => '🟡 В процессе',
                    'completed' => '✅ Завершено',
                }),

            TD::make('note', 'Примечание')
                ->render(fn($model) => Str::limit($model->note, 30))
        ];
    }

    public function legend(): array
    {
        return [
            Sight::make('product.name', 'Продукт'),
            Sight::make('status', 'Статус'),
            Sight::make('note', 'Примечание'),
        ];
    }

    public static function permission(): ?string
    {
        return 'platform.user.repairs.request';
    }

}
