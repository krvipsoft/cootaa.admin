<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class PageStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'content' => 'required|string'
        ];
    }
}
