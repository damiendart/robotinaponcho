<!--
  # This file is distributed under under the Creative Commons
  # Attribution 4.0 International License. To view a copy of this
  # license, please visit <http://creativecommons.org/licenses/by/4.0/>.

  description: Read Damien Dart's notes on setting up, using, and troubleshooting a Synology DiskStation.
  title: Synology DiskStation Notes
  twigTemplate: .templates/base-note.html.twig
-->

Transferring files between DiskStations (and other machines) using rsync
------------------------------------------------------------------------

This is one of those infrequent things that I can never remember the
right incantations for, so I'm jotting them down here to save myself any
future faff.

On the old device, enable the rsync service in the _File Services_
control panel if it hasn't been already.

Log into the new device via SSH and run a big ol' rsync command:

```
$ rsync --exclude '.DS_Store' --exclude '@eaDir' --exclude 'desktop.ini' -avhPc [SRC] [DEST] |& tee /tmp/rsync-output.txt
```

<div class="admonition admonition--info">
  <p><b>Note</b>: As the <code>-a</code> flag causes rsync to preserve
    groups and owners, you might get the dreaded <em>some files/attrs
    were not transferred</em> error at the end if there is any group or
    owner inconsistencies. Either review the rsync output to make sure
    it's nothing more serious, perform a dry-run transfer, or
    <a href="https://explainshell.com/explain?cmd=rsync+-a">replace the
    <code>-a</code> flag</a>.
</div>

After everything has been transferred over, you might need to clean up
any group, owner, or permission issues. (I've used [an approach from the
Synology knowledge base][2], but it's pretty heavy-handed.)

[2]: <https://www.synology.com/en-us/knowledgebase/DSM/tutorial/Management/Revert_to_Windows_ACL_permission>


Miscellaneous things
--------------------

  - Disable AFP (Apple Filling Protocol) support in the _File Services_
    control panel in DSM as it has been [deprecated for a while][3].
  - The _Task Scheduler_ control panel in DSM doesn't tell you whether a
    task's last run failed or succeeded.  Running the command
    `synoschedtask --get` provides detailed information about tasks,
    including their last run statuses.

[3]: <https://www.macworld.com/article/3600899/using-afp-to-share-a-mac-drive-its-time-to-change.html>
