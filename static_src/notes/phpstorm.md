<!--
  # This file is distributed under under the Creative Commons
  # Attribution 4.0 International License. To view a copy of this
  # license, please visit <http://creativecommons.org/licenses/by/4.0/>.

  description: Read Damien Dart's notes on setting up and using PhpStorm.
  title: PhpStorm Notes
  twigTemplate: .templates/notes-base.html.twig
-->

My PhpStorm Customisations and Settings
---------------------------------------

### Plugins

In addition to the plugins that come bundled with PhpStorm, I also use
[IdeaVim][1], because I'm one of those people, and the
[EditorConfig][2] plugin.

[1]: <https://github.com/JetBrains/ideavim>
[2]: <https://plugins.jetbrains.com/plugin/7294-editorconfig>

### Removing as much of the interface as possible

I'm also one of these people.

<div class="admonition admonition--info">
  <p><b>Note</b>: The search functionality in PhpStorm’s
    <em>Settings</em> window is pretty good, so I haven’t included the
    whole list of menus you need to drill down to find a setting.</p>
</div>

  - Turn on *Use contrast scrollbars*.
  - Turn on *Use smaller indents in trees*.
  - Turn off *Show tool window bars*.
  - Right-click the status bar and turn on the *Memory Indicator*.
  - Turn off *Display icons in menu items*.
  - Turn on *Widescreen tool window layout* (where appropriate).
  - Remove tabs completely (set *Tab Placement* to *None*) and instead
    rely on <kbd>Ctrl</kbd>+<kbd>E</kbd> (to switch between recent files)
    and <kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>E</kbd> (to switch between
    recently edited files).
  - Turn off *Show browsers popup in the editor*.
  - Hide the navigation bar (<span class="os-menu-item">View</span>
    &rarr; <span class="os-menu-item">Appearance</span> &rarr;
    <span class="os-menu-item">Navigation Bar</span>); on macOS,
    <kbd>&#8984;</kbd>+<kbd>&uarr;</kbd> will display a floating
    navigation bar if required.

### IdeaVim customisation and settings

  - Swap the audible bell for the visual one with `:set visualbell`.
  - On macOS, make IdeaVim a more pleasant experience by running
    `defaults write com.jetbrains.PhpStorm ApplePressAndHoldEnabled
    -bool false` in the terminal.

### Miscellaneous customisations and settings

  - I current use the Darcula theme throughout and [Iosekva][3] as my
    editor font.
  - Set the *Project Opening*'s *Default directory*.
  - Set some default visual guides at 72 and 78 characters.

[3]: <https://typeof.net/Iosevka/>
