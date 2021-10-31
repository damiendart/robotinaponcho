<!--
  # This file is distributed under under the Creative Commons
  # Attribution 4.0 International License. To view a copy of this
  # license, please visit <http://creativecommons.org/licenses/by/4.0/>.

  description: Read Damien Dart's notes on setting up and using PhpStorm.
  title: PhpStorm Notes
  twigTemplate: .templates/base-note.html.twig
-->

## My PhpStorm Customisations and Settings

Maybe one day I’ll get round to using a [settings repository][], but for
the moment running through this list takes at most ten minutes with a
fresh install of PhpStorm, so eh.

  [settings repository]: <https://www.jetbrains.com/help/phpstorm/sharing-your-ide-settings.html#settings-repository>

### Plugins

In addition to the plugins that come bundled with PhpStorm, I also use
[IdeaVim][], because I’m one of those people, and [Laravel Idea][].

  [IdeaVim]: <https://github.com/JetBrains/ideavim>
  [Laravel Idea]: <https://plugins.jetbrains.com/plugin/13441-laravel-idea>

### Removing as much of the interface as possible

I’m also one of these people.

**Note**: The search functionality in PhpStorm’s *Settings* window is
pretty good, so I haven’t included the whole list of menus you need to
drill down to find a setting.

-   Turn on *Use contrast scrollbars*.
-   Turn on *Use smaller indents in trees*.
-   Turn off *Show tool window bars*.
-   Right-click the status bar and turn on the *Memory Indicator*.
-   Turn off *Display icons in menu items*.
-   Turn on *Widescreen tool window layout* (where appropriate).
-   Remove tabs completely (set *Tab Placement* to *None*) and instead
    rely on <kbd>Ctrl</kbd>+<kbd>E</kbd> to switch between recent files.
-   Turn off *Show browsers popup in the editor*.
-   Hide the navigation bar (<span class="os-menu-item">View</span> →
    <span class="os-menu-item">Appearance</span> → <span
    class="os-menu-item">Navigation Bar</span>); on macOS,
    <kbd>⌘</kbd>+<kbd>↑</kbd> will display a floating navigation bar if
    required.

### IdeaVim customisations and settings

-   Swap the audible bell for the visual one with `:set visualbell`.
-   Use the IdeaVim *Settings* window (click the IdeaVim icon in the
    status bar and select *Settings…*) to set the
    <kbd>Ctrl</kbd>+<kbd>E</kbd> and <kbd>Ctrl</kbd>+<kbd>V</kbd>
    keyboard shortcuts to be handled by the IDE.
-   On macOS, make IdeaVim a more pleasant experience by running
    `defaults write com.jetbrains.PhpStorm ApplePressAndHoldEnabled -bool false`
    in the terminal.

### Miscellaneous customisations and settings

-   Check that PhpStorm is aware of all available PHP CLI interpreters
    in *Languages & Frameworks* → *PHP* in the *Settings* window.
-   If using PhpStorm 2020.3 or later, if the option is available sync
    the IDE theme with the OS (on macOS change the preferred light theme
    to *macOS Light*). Otherwise, use the Darcula theme throughout.
-   Set the editor font to [Iosekva][].
-   Set default visual guides at 72 and 78 characters.
-   Set the *Project Opening*’s *Default directory*.
-   Turn off the terminal’s *Audible bell*.

  [Iosekva]: <https://typeof.net/Iosevka/>

### Project-level customisations and settings

-   For projects that use NPM or Yarn, turn off the option to
    automatically add *node_modules/.bin* from the project root to
    `$PATH` (this one is a little tricky to search for in the *Settings*
    window; find it under *Tools* → *Terminal*).
