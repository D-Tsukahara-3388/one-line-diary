<?php
namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateMemoryRequest extends FormRequest
{
    /**
     * 
     * @return array
     */
    public function rules() :array
    {
        return[
            'recorded_date' => [
                'required', 
                'date',
                'unique:memories,recorded_date,NULL,id,user_id,' . auth::getUser()->id,
            ],
            'sentence' => ['required', 'string', 'max:50'],
            'image_file_path' => ['nullable', 'image', 'mimes:jpeg,jpg', 'max:10240'],
        ];
    }

    /**
     * 
     */
    public function prepareForValidation()
    {
        $this->merge([
            'recorded_date' => $this->input('recorded_date') ? Carbon::parse($this->input('recorded_date')) : null,
            'image_file_path' => $this->input('image_file_path') ?? null,
        ]);
    }
}