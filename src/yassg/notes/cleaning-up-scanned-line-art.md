<!---
  # This file is distributed under the Creative Commons Attribution 4.0
  # International License. To view a copy of this license, please visit
  # <http://creativecommons.org/licenses/by/4.0/>.

  collections:
    - 'adobe-creative-cloud'
    - 'notes'
  git: '$Metadata$'
  twigTemplate: .templates/base-note.html.twig
--->

Cleaning Up Scanned Line Art in Adobe Photoshop
===============================================

1.  Use adjustment layers to begin cleaning up your line art:
    - Remove any non-repro blue underdrawings with a *Hue/Saturation*
      adjustment layer. After choosing the *Cyans* colour range in the
      *Properties* panel, set the saturation to minimum and lightness to
      maximum.
    - Use *Curves* and/or *Levels* adjustment layers to improve the line
      quality and whites, and remove any remaining underdrawings.
    - For inked line art, use a *Threshold* adjustment layer to convert
      the line art to black-and-white bitmap.
2.  At the bottom of the *Channels* palette, click on *Load channel as
    selection* to create a selection of the white areas of the image.
3.  Invert the selection.
4.  Create a fill layer; the selection will be applied to the fill
    layer’s mask. Alternatively, use the *Paint Bucket* tool to fill the
    selection on a new layer.
5.  Deselect the selection.
6.  Delete or hide the scanned artwork and adjustment layers.
