#!/bin/sh
# Automate the compilation and installation of Gitweb, the Git web interface
# included in the Git distribution.

# TODO: Clean up and make more robust.

trap "rm -rf git-1.8.5.2" EXIT
USAGE=`cat <<USAGE;
USAGE: $(basename $0) [HTTP-DOC-FOLDER] [ADDITIONAL-BITS-FOLDER]
USAGE`
[ "$#" -lt 2 ] && { echo "Not enough operands\n$USAGE" >&2; exit 2; }
wget -O - https://github.com/git/git/archive/v1.8.5.2.tar.gz | tar -zx
(cd git-1.8.5.2 && make GITWEB_PROJECTROOT="${1%/}/git" \
    GITWEB_JS="/assets/gitweb.js" \
    GITWEB_CSS="/assets/gitweb.css" \
    GITWEB_SITENAME="GitHub Mirror" \
    GITWEB_LOGO="/assets/git-logo.png" \
    GITWEB_FAVICON="/assets/git-favicon.png" \
    GITWEB_CONFIG="${2%/}/gitweb_config.perl" \
    bindir="/usr/local/bin" \
    gitwebdir="${1%/}/git" \
    gitweb install-gitweb &&
    mv ${$1%/}/git/static/* ${1%/}/assets && rm -fr ${1%/}/git/static)
