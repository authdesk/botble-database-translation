<?php

namespace Botble\AdminAddon\Http\Controllers;

require_once __DIR__ . '/../../../vendor/autoload.php';

use Botble\AdminAddon\Http\Requests\DatabaseTranslationRequest;
use Botble\AdminAddon\Models\DatabaseTranslation;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\AdminAddon\Tables\DatabaseTranslationTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\AdminAddon\Forms\DatabaseTranslation\CreateForm;
use Botble\AdminAddon\Forms\DatabaseTranslation\EditForm;
use Botble\Base\Forms\FormBuilder;
use Stichoza\GoogleTranslate\GoogleTranslate;

class DatabaseTranslationController extends BaseController
{
    public function index(DatabaseTranslationTable $table)
    {
        PageTitle::setTitle(trans('plugins/admin-addon::database-translation.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/admin-addon::database-translation.create'));

        return $formBuilder->create(CreateForm::class)->renderForm();
    }

    public function store(DatabaseTranslationRequest $request, BaseHttpResponse $response)
    {
        $languages = $request->lang;
        $all_text = $request->text;

        $data_exist = [];

       foreach ($languages as $lang) {
            $translator = new GoogleTranslate();
            $translator->setTarget($lang); 

            foreach ($all_text as $text) {

                $textToTranslate = $text;
                $translation = $translator->translate($textToTranslate);

                $data['text'] = $textToTranslate;
                $data['lang'] = $lang;
                $data['translation'] = $translation;

                $translation_exits = DatabaseTranslation::where('text', $textToTranslate)->where('lang', $lang)->first();

                if($translation_exits){
                    array_push($data_exist,  $data['text']."[".$data['lang']."]");
                } else {
                    $database_translation = DatabaseTranslation::query()->create($data);
                }
            }
       }

       $data_exist = implode(", ", $data_exist);

       if (!empty($data_exist)) {
            $message = trans('plugins/admin-addon::database-translation.data_exist')."[data_exist=".$data_exist."]";
            return $response
                ->setError()
                ->setPreviousUrl(route('database-translation.index'))
                ->setMessage($message);
        }

        event(new CreatedContentEvent(DATABASE_TRANSLATION_MODULE_SCREEN_NAME, $request, $database_translation));

        return $response
            ->setPreviousUrl(route('database-translation.index'))
            ->setNextUrl(route('database-translation.edit', $database_translation->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(DatabaseTranslation $database_translation, FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/admin-addon::database-translation.edit'));

        return $formBuilder->create(EditForm::class, ['model' => $database_translation])->renderForm();
    }

    public function update(DatabaseTranslation $database_translation, DatabaseTranslationRequest $request, BaseHttpResponse $response)
    {
        $database_translation->fill($request->input());

        $database_translation->save();

        event(new UpdatedContentEvent(DATABASE_TRANSLATION_MODULE_SCREEN_NAME, $request, $database_translation));

        return $response
            ->setPreviousUrl(route('database-translation.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(DatabaseTranslation $database_translation, Request $request, BaseHttpResponse $response)
    {
        try {
            $database_translation->delete();

            event(new DeletedContentEvent(DATABASE_TRANSLATION_MODULE_SCREEN_NAME, $request, $database_translation));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
