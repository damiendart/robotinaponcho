<?php

// Copyright (C) 2021 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

return json_decode(
    file_get_contents(
        getenv('SHARED_ROOT') . '/protected/git/metadata.json'
    ),
    true
);
