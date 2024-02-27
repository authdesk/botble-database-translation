<?php

return [
    [
        'name' => 'Database Translation',
        'flag' => 'database-translation.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'database-translation.create',
        'parent_flag' => 'database-translation.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'database-translation.edit',
        'parent_flag' => 'database-translation.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'database-translation.destroy',
        'parent_flag' => 'database-translation.index',
    ],
];
