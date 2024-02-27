<?php

namespace Botble\AdminAddon\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\AdminAddon\Models\DatabaseTranslation;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\Columns\Column;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;

class DatabaseTranslationTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(DatabaseTranslation::class)
            ->addActions([
                EditAction::make()
                    ->route('database-translation.edit'),
                DeleteAction::make()
                    ->route('database-translation.destroy'),
            ]);
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('text', function (DatabaseTranslation $item) {
                if (! $this->hasPermission('database-translation.edit')) {
                    return BaseHelper::clean($item->text);
                }
                return Html::link(route('database-translation.edit', $item->getKey()), BaseHelper::clean($item->text));
            });

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this
            ->getModel()
            ->query()
            ->select([
               'id',
               'text',
               'lang',
               'translation',
               'created_at',
           ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            Column::make('text')
                    ->title(trans('plugins/admin-addon::database-translation.text')),
            Column::make('lang')
                    ->title(trans('plugins/admin-addon::database-translation.lang')),
            Column::make('translation')
                    ->title(trans('plugins/admin-addon::database-translation.translation')),

        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('database-translation.create'), 'database-translation.create');
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('database-translation.destroy'),
        ];
    }

}
