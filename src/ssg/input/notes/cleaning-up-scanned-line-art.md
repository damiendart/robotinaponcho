<!---
# This file is distributed under the Creative Commons Attribution 4.0
# International License. To view a copy of this license, please visit
# <http://creativecommons.org/licenses/by/4.0/>.

collections:
  - 'adobe-creative-cloud'
  - 'notes'
git: '$Metadata$'
template: .templates/note.html.twig
--->

Cleaning Up Scanned Line Art in Adobe Photoshop
===============================================

1.  Use adjustment layers to begin cleaning up your line art.
    -   Remove any non-repro blue underdrawings with a *Hue/Saturation*
        adjustment layer: choose the *Cyans* colour range in the
        *Properties* panel and set the saturation to minimum and
        lightness to maximum.
    -   Use *Curves* and/or *Levels* adjustment layers to remove any
        remaining underdrawings, and to improve the line quality and
        whites.
    -   For high-DPI inked line art, use a *Threshold* adjustment layer
        to convert the line art to black-and-white bitmap. This makes
        [flatting][] easier.
2.  At the bottom of the *Channels* palette, click on *Load channel as
    selection* to create a selection of the white areas of the image.
3.  Invert the selection.
4.  On a new layer, use the *Paint Bucket* tool to fill the selection
    with black.
5.  Deselect the selection, and hide the scanned artwork and adjustment
    layers. (I prefer to hide these layers instead of deleting them so I
    can refer back to the adjustment values I used.)

  [flatting]: <https://en.wikipedia.org/wiki/Flatter>
