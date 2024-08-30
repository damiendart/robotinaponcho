<!---
# This file is distributed under the Creative Commons Attribution 4.0
# International License. To view a copy of this license, please visit
# <http://creativecommons.org/licenses/by/4.0/>.

collections:
  - 'docker'
  - 'notes'
git: '$Metadata$'
template: .templates/base-note.html.twig
--->

Running an Ad-Hoc MySQL Instance Locally with Docker
====================================================

For some reason I am incapable of committing the following to memory:

``` shell
$ docker run --name mysql -p 3306:3306 -e MYSQL_ROOT_PASSWORD=root -d mysql
$ docker exec -it mysql mysql -uroot -p
```

Adding `--restart=unless-stopped` to the `docker run` command will make
the MySQL instance persist after a system restart or shutdown.
