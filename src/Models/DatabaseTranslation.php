<?php

namespace Botble\AdminAddon\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

/**
 * @method static \Botble\Base\Models\BaseQueryBuilder<static> query()
 */
class DatabaseTranslation extends BaseModel
{
    protected $table = 'database_translations';

    protected $fillable = [
        'text',
        'lang',
        'translation'
    ];

    protected $casts = [
        'text' => SafeContent::class,
    ];
}
