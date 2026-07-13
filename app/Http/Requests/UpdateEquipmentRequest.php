<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'qty' => $this->normalizeIntegerInput($this->input('qty')),
            'received_quantity' => $this->normalizeIntegerInput($this->input('received_quantity')),
            'used_quantity' => $this->normalizeIntegerInput($this->input('used_quantity')),
            'balance_quantity' => $this->normalizeIntegerInput($this->input('balance_quantity')),
        ]);
    }

    private function normalizeIntegerInput(mixed $value): mixed
    {
        if ($value === null || $value === '') {
            return $value;
        }

        if (is_int($value)) {
            return $value;
        }

        if (is_string($value) && preg_match('/^\d+$/', $value)) {
            return (int) ltrim($value, '0');
        }

        return $value;
    }

    public function rules(): array
    {
        $equipmentId = $this->route('id');

        return [
            'equipment' => ['required', 'string', 'max:255', Rule::exists('lf_03_05', 'equipment')],
            'equipment_no' => ['required', 'string', 'max:255', Rule::exists('lf_03_05', 'equipment_no'), Rule::unique('equipment', 'equipment_no')->ignore($equipmentId)],
            'qty' => ['required', 'integer', 'min:0'],
            'unit' => ['nullable', 'string', 'max:255'],
            'rfl_control_no' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'brand_model' => ['nullable', 'string', 'max:255'],
            'date_acquired' => ['nullable', 'date'],
            'unit_cost' => ['required', 'numeric', 'min:0'],
            'total_cost' => ['nullable', 'numeric', 'min:0'],
            'status_remarks' => ['nullable', 'string', 'max:5000'],
            'received_quantity' => ['required', 'integer', 'min:0'],
            'used_quantity' => ['required', 'integer', 'min:0'],
            'balance_quantity' => ['nullable', 'integer', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'person_in_charge' => ['nullable', 'array'],
            'person_in_charge.*' => ['integer', 'distinct', Rule::exists('users', 'id')],
            'updates' => ['nullable', 'string', 'max:10000'],
        ];
    }

    public function messages(): array
    {
        return (new StoreEquipmentRequest())->messages();
    }
}