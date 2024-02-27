<?php

namespace Botble\AdminAddon\Forms\DatabaseTranslation;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\AdminAddon\Http\Requests\DatabaseTranslationRequest;
use Botble\AdminAddon\Models\DatabaseTranslation;
use Botble\Language\Facades\Language;

class EditForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this->setupModel(new DatabaseTranslation)
            ->setValidatorClass(DatabaseTranslationRequest::class)
            ->withCustomFields()
            ->add('text', 'textarea', [
                'label' => trans('plugins/admin-addon::database-translation.text'),
                'required' => true,
                'attr' => [
                    'placeholder' => trans('plugins/admin-addon::database-translation.text'),
                    'rows'        => 3,
                ],
            ])
            ->add('lang', 'text', [
                'label' => trans('plugins/admin-addon::database-translation.lang'),
                'attr' => [
                    'placeholder' => trans('plugins/admin-addon::database-translation.lang'),
                    'readonly'    => true,
                    'style'       => 'background-color: #f2f2f2;'
                ],
            ])
            ->add('translation', 'textarea', [
                'label' => trans('plugins/admin-addon::database-translation.translation'),
                'attr' => [
                    'placeholder' => trans('plugins/admin-addon::database-translation.translation'),
                    'rows'        => 3,
                ],
            ]);
    }
}
