<!---
# This file is distributed under the Creative Commons Attribution 4.0
# International License. To view a copy of this license, please visit
# <http://creativecommons.org/licenses/by/4.0/>.

collections:
  - 'notes'
  - 'synology-diskstation'
git: '$Metadata$'
template: _templates/note.html.twig
--->

Getting More Information About Scheduled Tasks on Synology DiskStations
=======================================================================

The *Task Scheduler* control panel in Synology DiskStation Manager (DSM)
doesn’t tell you whether a task’s last run was successful or not.

Logging into your device via SSH and running the command
`synoschedtask --get` provides detailed information about tasks,
including their last run statuses.
