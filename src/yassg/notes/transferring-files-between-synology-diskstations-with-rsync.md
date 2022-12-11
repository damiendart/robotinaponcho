<!---
  # This file is distributed under the Creative Commons Attribution 4.0
  # International License. To view a copy of this license, please visit
  # <http://creativecommons.org/licenses/by/4.0/>.

  collections:
    - 'notes'
    - 'synology-diskstation'
  twigTemplate: .templates/base-note.html.twig
--->

Transferring Files Between Synology DiskStations with rsync
===========================================================

On the old device, enable the rsync service in the *File Services*
control panel in the DiskStation Manager (DSM).

Log into the new device via SSH and run a big ol’ rsync command:

``` shell
$ rsync --exclude '.DS_Store' --exclude '@eaDir' --exclude 'desktop.ini' -avhPc [SRC] [DEST] |& tee /tmp/rsync-output.txt
```

**Note:** When using the `-a` flag, you might get a “some files/attrs
were not transferred” error at the end. This may be due to group or
owner attribute inconsistencies between the two machines. To check,
review the rsync output or perform a dry-run transfer. Alternatively,
[replace the `-a` flag][] before running the rsync command.

After everything has been transferred over, you might need to clean up
any group, owner, or permission issues. (I’ve used [an approach from the
Synology knowledge base][], but it’s pretty heavy-handed.)

  [replace the `-a` flag]: <https://explainshell.com/explain?cmd=rsync+-a>
  [an approach from the Synology knowledge base]: <https://www.synology.com/en-us/knowledgebase/DSM/tutorial/Management/Revert_to_Windows_ACL_permission>
