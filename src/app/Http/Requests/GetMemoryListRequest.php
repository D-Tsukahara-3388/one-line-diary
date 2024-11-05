<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class GetMemoryListRequest extends FormRequest
{
    /**
     * 
     * @return array
     */
    public function rules() :array
    {
        return[
            'page' => ['required', 'integer'],
            'per_page' => ['required', 'integer'],
            'search' => ['array'],
            'search.free_word' => ['nullable', 'string'],
            'search.recorded_date_from' => ['nullable', 'date'],
            'search.recorded_date_to' => ['nullable', 'date'],
        ];
    }

    /**
     * 
     */
    public function prepareForValidation()
    {
        $this->merge([
            'page' => $this->input('page', 1),
            'per_page' => $this->input('per_page', 5),
            'search' => [
                'free_word' => $this->input('free_word') ?? null,
                'recorded_date_from' => $this->input('recorded_date_from') ? Carbon::parse($this->input('recorded_date_from')) : null,
                'recorded_date_to' => $this->input('recorded_date_to') ? Carbon::parse($this->input('recorded_date_to')) : null,
            ],
        ]);
    }
}