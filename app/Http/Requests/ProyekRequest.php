<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyekRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_proyek' => 'string|required',
            'category_proyek_id' => 'integer|required',
            'tanggal_mulai' => 'date|required',
            'tanggal_selesai' => 'date|required',
            'status_proyek' => 'string|required',
            'biaya_proyek' => 'integer|required',
        ];
    }
}
