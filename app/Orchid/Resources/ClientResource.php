<?php

namespace App\Orchid\Resources;

use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class ClientResource extends Resource
{
    /**
     * Модель, соответствующая ресурсу.
     *
     * @var string
     */
    public static $model = \App\Models\Client::class;

    public static function icon(): string
    {
        return 'bs.people';
    }

    public static function label(): string
    {
        return 'Клиенты';
    }

    public static function createButtonLabel(): string
    {
        return 'Создать клиента';
    }

    public static function updateButtonLabel(): string
    {
        return 'Сохранить изменения';
    }

    public static function deleteButtonLabel(): string
    {
        return 'Удалить клиента';
    }

    /**
     * Определяет, какие поля отображаются при создании и редактировании.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('name')
                ->title('Имя клиента')
                ->placeholder('Введите имя клиента')
                ->required(),

            Input::make('email')
                ->title('Email')
                ->placeholder('example@mail.com')
                ->type('email')
                ->required(),

            Input::make('phone')
                ->title('Телефон')
                ->placeholder('+7XXXXXXXXXX')
                ->mask('+79999999999')
                ->required()
                ->help('Номер телефона должен начинаться с +7 и состоять из 11 цифр')
                ->min(12)
                ->max(12),
        ];
    }

    /**
     * Определяет колонки таблицы в списке.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id', 'ID')->sort(),
            TD::make('name', 'Имя клиента'),
            TD::make('email', 'Email'),
            TD::make('phone', 'Телефон'),
        ];
    }

    /**
     * Отображение полей в режиме просмотра (легенды).
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('name', 'Имя клиента'),
            Sight::make('email', 'Email'),
            Sight::make('phone', 'Телефон'),
        ];
    }

    /**
     * Фильтры (если нужны).
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    /**
     * Ограничения доступа на основе разрешений.
     *
     * @return iterable|null
     */
    public static function permission(): ?string
    {
        return 'platform.clients';
    }

}
