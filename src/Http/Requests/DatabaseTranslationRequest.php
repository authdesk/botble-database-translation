<?php

namespace Botble\AdminAddon\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class DatabaseTranslationRequest extends Request
{
    public function rules(): array
    {
        return [
            'text' => 'required',
            'lang' => 'required',
        ];
    }
}
