<!--
  # This file is distributed under under the Creative Commons
  # Attribution 4.0 International License. To view a copy of this
  # license, please visit <http://creativecommons.org/licenses/by/4.0/>.

  description: Read Damien Dart's notes on setting up and using PhpStorm.
  slug: notes/phpstorm
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

 - Hide all tool window bars by clicking the square icon in the lower
   left corner of the workspace.
 - Turn off *Display icons in menu items*.
 - Turn on *Show memory indicator*.
 - Turn on *Widescreen tool window layout* (where appropriate).
 - Remove tabs completely (set *Tab Placement* to *None*) and instead
   rely on <kbd>Ctrl</kbd>+<kbd>E</kbd> (to switch between recent files)
   and <kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>E</kbd> (to switch between
   recently edited files).
 - Turn off *Show browsers popup in the editor*.

### Miscellaneous customisations and settings

 - I current use the Darcula theme throughout and [Iosekva][3] as my
   editor font.
 - Set the *Project Opening*'s *Default directory*.
 - Set some default visual guides at 70 and 78 characters.
 - On macOS, make IdeaVim a more pleasant experience by running
  `defaults write com.jetbrains.PhpStorm ApplePressAndHoldEnabled
  -bool false` in the terminal.

[3]: <https://typeof.net/Iosevka/>
