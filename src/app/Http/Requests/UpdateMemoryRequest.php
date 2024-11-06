<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemoryRequest extends FormRequest
{
    /**
     * 
     * @return array
     */
    public function rules() :array
    {
        return[
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
            'image_file_path' => $this->input('image_file_path') ?? null,
        ]);
    }

}