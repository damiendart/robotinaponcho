#!/bin/sh
#
# Copyright (C) Damien Dart, <damiendart@pobox.com>.
# This file is distributed under the MIT licence. For more
# information, please refer to the accompanying "LICENCE" file.

set -e

if [ "$1" = '--smudge' ]; then
  shift

  CREATED=$(git log --diff-filter=A --follow --format='%H %ct' -1 -- "$1")
  LAST_UPDATED=$(git log -n 1 --pretty=format:'%H %ct' -- "$1")

  sed "s/\\\$Metadata\\\$/\$Metadata: $CREATED $LAST_UPDATED\$/g"
  exit
fi

# shellcheck disable=SC2016
sed 's/\$Metadata[^$]*\$/$Metadata$/g'
