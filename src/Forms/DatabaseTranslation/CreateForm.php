<?php

namespace Botble\AdminAddon\Forms\DatabaseTranslation;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\AdminAddon\Http\Requests\DatabaseTranslationRequest;
use Botble\AdminAddon\Models\DatabaseTranslation;
use Botble\Language\Facades\Language;

class CreateForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this->setupModel(new DatabaseTranslation)
            ->setValidatorClass(DatabaseTranslationRequest::class)
            ->withCustomFields();
            
        $languages = Language::getActiveLanguage(['lang_id', 'lang_name', 'lang_locale']);

        $this->addMetaBoxes([
                'database_translation_box' => [
                    'title' => trans('plugins/admin-addon::database-translation.create'),
                    'content' => view('plugins/admin-addon::database-translation.database-translation-form', compact('languages')),
                ],
        ]);
    }
}
