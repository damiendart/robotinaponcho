#!/bin/sh
# Automate the compilation and installation of Gitweb, the Git web interface
# included in the Git distribution.

# TODO: Clean up and make more robust.

trap "rm -rf git-1.8.5.2" EXIT
USAGE=`cat <<USAGE;
USAGE: $(basename $0) HTDOCS-FOLDER PROTECTED-FOLDER [MAKE-COMMAND]
USAGE`
[ "$#" -lt 2 ] && { echo "Not enough operands\n$USAGE" >&2; exit 2; }
wget -O - https://github.com/git/git/archive/v1.8.5.2.tar.gz | tar -zxf -
(cd git-1.8.5.2 && ${3:-make} bindir="/usr/local/bin" \
    GITWEB_CONFIG="${2%/}/gitweb_config.perl" \
    GITWEB_CSS="/assets/gitweb.css" GITWEB_FAVICON="/assets/git-favicon.png" \
    GITWEB_JS="/assets/gitweb.js" GITWEB_LOGO="/assets/git-logo.png" \
    GITWEB_PROJECTROOT="${1%/}/git" GITWEB_SITENAME="GitHub Mirror" \
    gitwebdir="${1%/}/git" gitweb install-gitweb &&
    mv ${1%/}/git/static/* ${1%/}/assets && rm -fr ${1%/}/git/static)
patch ${1%/}/git/gitweb.cgi <<'PATCH'
--- Original
+++ Modified
@@ -4066,7 +4066,7 @@
 <head>
 <meta http-equiv="content-type" content="$content_type; charset=utf-8"/>
 <meta name="generator" content="gitweb/$version git/$git_version$mod_perl_version"/>
-<meta name="robots" content="index, nofollow"/>
+<meta name="robots" content="noindex, nofollow"/>
 <title>$title</title>
 EOF
 	# the stylesheet, favicon etc urls won't work correctly with path_info
PATCH
