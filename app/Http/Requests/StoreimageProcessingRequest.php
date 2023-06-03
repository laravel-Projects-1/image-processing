<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class StoreimageProcessingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'image' => ['required'],
            'width' => ['required','regex:/^\d+(\.\d+)?%?$/'],
            'height' => 'regex:/^\d+(\.\d+)?%?$/',
            'album_id' => ['exists:\App\models\Album,id']
        ];

        $image = $this->post('image');
        if($image && $image instanceof UploadedFile) {
            $rules['image'][] = 'image';
        } else {
            $rules['image'][] = 'url';
        }

        return $rules;
    }
}
