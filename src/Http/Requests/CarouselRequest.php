<?php

namespace Combindma\Carousel\Http\Requests;

use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;

class CarouselRequest extends FormRequest
{
    use SanitizesInput;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
            'published_at' => 'required|date_format:Y-m-d\TH:i',
            'is_published' => 'present|boolean',
            'is_featured' => 'present|boolean',
            'featured_image' => ['nullable', 'file', 'mimes:png,jpg,jpeg', 'dimensions:max_width=2500,max_height=2500', 'max:1024'],
            'images.*' => ['nullable', 'file', 'mimes:png,jpg,jpeg', 'dimensions:max_width=2500,max_height=2500', 'max:1024'],
            'meta' => 'nullable|array'
        ];
    }

    public function filters()
    {
        return [
            'title' => 'trim|lowercase',
            'description' => 'trim|lowercase',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'titre',
            'content' => 'contenu',
            'published_at' => 'date publication',
            'featured_image' => 'image mise en avant',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_published' => $this->is_published??0,
            'is_featured' => $this->is_featured??0,
        ]);
    }
}
