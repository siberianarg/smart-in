<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Определяет, авторизован ли пользователь.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Разрешаем выполнение запроса
    }

    /**
     * Возвращает правила валидации запроса.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
{
    return [
        'name' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
        'moment' => 'nullable|date_format:Y-m-d H:i:s',
        
        // организация
        'organization' => 'required|array',
        'organization.meta.href' => 'required|string|url',

        // контрагент (агент)
        'agent' => 'required|array',
        'agent.meta.href' => 'required|string|url',

        // канал продаж
        'salesChannel' => 'nullable|array',
        'salesChannel.meta.href' => 'required_with:salesChannel|string|url',

        // проект
        'project' => 'nullable|array',
        'project.meta.href' => 'required_with:project|string|url',

        // состояние заказа
        'state' => 'nullable|array',
        'state.meta.href' => 'required_with:state|string|url',

        // атрибуты
        'attributes' => 'nullable|array',
        'attributes.*.id' => 'required|string|uuid',
        'attributes.*.value' => 'required',

        // позиции заказа
        'positions' => 'required|array|min:1',
        'positions.*.quantity' => 'required|integer|min:1',
        'positions.*.price' => 'required|numeric|min:0',
        'positions.*.assortment' => 'required|array',
        'positions.*.assortment.meta.href' => 'required|string|url',
    ];
}

}
