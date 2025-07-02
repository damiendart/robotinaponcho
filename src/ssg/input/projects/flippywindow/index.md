<!---
# Copyright (C) Damien Dart, <damiendart@pobox.com>.
# This file is distributed under the MIT licence. For more
# information, please refer to the accompanying "LICENCE" file.

description: 'Download FlippyWindow, a simple Windows application that non-destructively flips any part of your screen.'
section: 'projects'
template: '_templates/flippywindow.html.twig'
title: 'FlippyWindow'
--->

## Frequently asked questions

### Can’t I just use any image editor to do what FlippyWindow does?

Last time I looked, [Adobe Photoshop CC 2019][] (and later), [Clip Paint
Studio][], [Krita][], and [PaintTool SAI][] have features that allow you
to non-destructively change how you view an image, so chances are
FlippyWindow isn't necessary.

I built FlippyWindow mainly to see if something like it was possible,
and because, at the time, I could only flip images the “old-fashioned”
way which would make my crappy underpowered laptop very sad.

FlippyWindow can also help you spot visual issues in work outside of
image editors, including animations, application user interfaces, and
website designs.

  [Adobe Photoshop CC 2019]: <https://www.adobe.com/products/photoshop.html>
  [Clip Paint Studio]: <https://www.clipstudio.net/>
  [Krita]: <https://krita.org/>
  [PaintTool SAI]: <https://www.systemax.jp/en/sai/>

### What is itch.io?

[itch.io][] describes itself as “an open marketplace for independent
digital creators”. It allows me to offer FlippyWindow with
pay-what-you-want pricing.

If you want to support FlippyWindow and anything else I make, please
consider naming your price before downloading. This is completely
optional; you can download FlippyWindow without paying or signing up to
anything.

  [itch.io]: <https://itch.io/>

<h3 id="alternative-download-locations">Is FlippyWindow available elsewhere?</h3>

You can download FlippyWindow from this website:

-   [Download a ZIP archive containing a 32-bit FlippyWindow binary][].
-   [Download a ZIP archive containing a 64-bit FlippyWindow binary][].

If you are unsure which archive to download, the 64-bit version is
usually your best bet. [SHA-256 checksums][] are also available to
verify the archive downloads (either from here or itch.io).

<h3 id="open-source">Is FlippyWindow open-source?</h3>

FlippyWindow’s source code is licenced under [the MIT licence][] and is
available on [my personal site][] and [GitHub][].

  [itch.io]: <https://itch.io/>
  [Download a ZIP archive containing a 32-bit FlippyWindow binary]: <https://www.robotinaponcho.net/projects/flippywindow/flippywindow-32-bit.zip>
  [Download a ZIP archive containing a 64-bit FlippyWindow binary]: <https://www.robotinaponcho.net/projects/flippywindow/flippywindow-64-bit.zip>
  [SHA-256 checksums]: <https://www.robotinaponcho.net/projects/flippywindow/flippywindow-checksums.txt>
  [the MIT licence]: <https://github.com/damiendart/flippywindow/blob/master/LICENCE>
  [my personal site]: <https://www.robotinaponcho.net/git/#flippywindow>
  [GitHub]: <https://github.com/damiendart/flippywindow>

### Will earlier versions of Windows, Linux and macOS be supported?

FlippyWindow (ab)uses APIs that were introduced in Windows 8
(specifically the second release of the Magnification API).

FlippyWindow works on the operating systems I use, so there are no plans
to investigate whether FlippyWindow can support earlier versions of
Windows and other operating systems.


## Changelog

### Version 1.0.0 (01/04/2018)

-   Initial release.
