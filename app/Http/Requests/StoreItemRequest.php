<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use League\CommonMark\CommonMarkConverter;

class StoreItemRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'url' => 'required|url',
            'description' => 'required|string',
            'provider' => 'required|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'description' => (new CommonMarkConverter(['html_input' => 'escape', 'allow_unsafe_links' => false]))
                ->convert($this->description)
                ->getContent(),
            'provider' => parse_url($this->url, PHP_URL_HOST),
        ]);
    }
}
