<!---
# This file is distributed under the Creative Commons Attribution 4.0
# International License. To view a copy of this license, please visit
# <http://creativecommons.org/licenses/by/4.0/>.

collections:
  - 'docker'
  - 'notes'
git: '$Metadata$'
twigTemplate: .templates/base-note.html.twig
--->

Updating Docker Containers with Docker Compose
==============================================

I use Docker Compose to manage the Docker containers I run on my
[Synology DiskStation][]. If there are changes to `docker-composer.yml`
that need deploying or the containers currently running need updating,
the following will ensure everything is up-to-date and any detritus is
cleared up:

``` shell
$ docker-compose pull
$ docker-compose up -d --build --force-recreate --remove-orphans
$ docker image prune -f
$ docker volume ls -f dangling=true
$ # If dangling volumes exist, remove them with "docker volume prune -f".
```

You may need to run these commands with `sudo`. The Docker documentation
has more information [on pruning unused Docker objects][] if the above
pruning commands don’t go far enough.

If, like me, you’re running these commands on a DiskStation, you can
safely ignore any “Docker container stopped unexpectedly” notifications
from DiskStation Manager.

  [Synology DiskStation]: <https://www.robotinaponcho.net/notes/#synology-diskstation>
  [on pruning unused Docker objects]: <https://docs.docker.com/config/pruning/>
