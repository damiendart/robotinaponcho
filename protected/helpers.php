<?php

/*
 * Copyright (C) Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

/**
 * @throws Exception
 */
function git(string $command, ?string $cwd = null): string
{
    $pipes = [];
    $resource = proc_open(
        "git {$command}",
        [1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
        $pipes,
        $cwd,
    );
    $stderr = stream_get_contents($pipes[2]);
    $stdout = stream_get_contents($pipes[1]);

    foreach ($pipes as $pipe) {
        fclose($pipe);
    }

    if (0 !== proc_close($resource)) {
        throw new Exception(
            "Git command \"{$command}\" exited with a non-zero status\n{$stderr}",
        );
    }

    return trim($stdout);
}
