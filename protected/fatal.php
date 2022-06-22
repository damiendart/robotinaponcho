<?php

/*
 * Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont,
                "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell,
                "Helvetica Neue", Helvetica, Arial, "Noto Sans",
                "Liberation Sans", sans-serif;
            padding: 10%;
            text-align: center;
            line-height: 1.5rem;
        }
        p {
            margin: 0 auto;
            max-width: 20rem;
        }
        svg {
            fill: none;
            height: 4.5rem;
            margin: 0 auto 0.75rem;
            stroke: #c0392b;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 2px;
            width: 4.5rem;
        }
    </style>
</head>
<body>
    <svg height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" x2="12" y1="8" y2="12"></line>
        <line x1="12" x2="12.01" y1="16" y2="16"></line>
    </svg>
    <p><strong>This page is currently offline due to an unexpected
        error.</strong> An administrator has been&nbsp;notified.</p>
</body>
</html>
