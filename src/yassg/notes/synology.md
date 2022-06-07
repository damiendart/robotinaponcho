<!---
  # This file is distributed under the Creative Commons Attribution 4.0
  # International License. To view a copy of this license, please visit
  # <http://creativecommons.org/licenses/by/4.0/>.

  collections: 'notes'
  description: Read Damien Dart's notes on setting up, using, and troubleshooting a Synology DiskStation.
  title: Synology DiskStation Notes
  twigTemplate: .templates/base-note.html.twig
--->

## Transferring files between DiskStations using rsync

This is one of those infrequent things that I can never remember the
right incantations for, so I’m jotting them down here to save myself any
future faff.

On the old device, enable the rsync service in the *File Services*
control panel.

Log into the new device via SSH and run a big ol’ rsync command:

    $ rsync --exclude '.DS_Store' --exclude '@eaDir' --exclude 'desktop.ini' -avhPc [SRC] [DEST] |& tee /tmp/rsync-output.txt

**Note:** As the `-a` flag causes rsync to preserve groups and owners,
you might get the dreaded *some files/attrs were not transferred* error
at the end if there is any group or owner inconsistencies. Either review
the rsync output to make sure it’s nothing more serious, perform a
dry-run transfer, or [replace the `-a` flag][].

After everything has been transferred over, you might need to clean up
any group, owner, or permission issues. (I’ve used [an approach from the
Synology knowledge base][], but it’s pretty heavy-handed.)

  [replace the `-a` flag]: <https://explainshell.com/explain?cmd=rsync+-a>
  [an approach from the Synology knowledge base]: <https://www.synology.com/en-us/knowledgebase/DSM/tutorial/Management/Revert_to_Windows_ACL_permission>


## Miscellaneous things

-   Disable AFP (Apple Filling Protocol) support in the *File Services*
    control panel in DSM as it has been [deprecated for a while][].
    Recent versions of DSM already have AFP disabled by default.
-   The *Task Scheduler* control panel in DSM doesn’t tell you whether a
    task’s last run failed or succeeded. Running the command
    `synoschedtask --get` provides detailed information about tasks,
    including their last run statuses.

  [deprecated for a while]: <https://www.macworld.com/article/3600899/using-afp-to-share-a-mac-drive-its-time-to-change.html>
