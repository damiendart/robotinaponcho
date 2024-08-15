<!---
# This file is distributed under the Creative Commons Attribution 4.0
# International License. To view a copy of this license, please visit
# <http://creativecommons.org/licenses/by/4.0/>.

collections:
  - 'command-line'
  - 'notes'
git: '$Metadata$'
twigTemplate: .templates/base-note.html.twig
--->

Image Filesize Reduction Techniques
===================================

Use [ExifTool][] and [jpegtran][] to reduce JPEG image filesizes:

``` shell
$ jpegtran -optimize -progressive [IMAGE] > [OUTPUT] && exiftool -all= --icc_profile:all [OUTPUT]
```

  [ExifTool]: <https://exiftool.org>
  [jpegtran]: <https://jpegclub.org/jpegtran/>
