<!---
# This file is distributed under the Creative Commons Attribution 4.0
# International License. To view a copy of this license, please visit
# <http://creativecommons.org/licenses/by/4.0/>.

collections:
  - 'jetbrains-ides'
  - 'notes'
git: '$Metadata$'
template: .templates/base-note.html.twig
--->

My PhpStorm Customisations and Settings
=======================================

Maybe one day I’ll get round to using a [settings repository][], but for
the moment going through this list with a fresh installation of PhpStorm
takes a couple of minutes, so eh.

**Note**: The search functionality in PhpStorm’s *Settings* window is
pretty good, so I haven’t included the whole hierarchy of menus you need
to drill down to find a particular setting. Use the setting name
formatted in *italics* as the search term.

  [settings repository]: <https://www.jetbrains.com/help/phpstorm/settings-tools-settings-repository.html>


## Plugins

In addition to the plugins that come bundled with PhpStorm, I also use
[IdeaVim][] (because I’m one of those people), [Key Promoter X][], and
[Laravel Idea][].

  [IdeaVim]: <https://github.com/JetBrains/ideavim>
  [Key Promoter X]: <https://plugins.jetbrains.com/plugin/9792-key-promoter-x>
  [Laravel Idea]: <https://plugins.jetbrains.com/plugin/13441-laravel-idea>


## Removing as much of the interface as possible

I’m also one of these people.

-   Set the IDE theme to Dark.
-   Turn on *Use contrast scrollbars*.
-   Turn on *Compact mode*.
-   Turn off *Display icons in menu items*.
-   Turn on *Use smaller indents* for tree views.
-   Right-click the status bar and turn on the *Memory Indicator*.
-   Turn on *Widescreen tool window layout* (where appropriate).
-   Remove tabs completely (set *Tab Placement* to *None*) and instead
    rely on <kbd>Ctrl</kbd>+<kbd>E</kbd> to switch between recent files.
-   Turn off *Show browsers popup in the editor*.
-   Hide the navigation bar (<span class="os-menu-item">View</span> →
    <span class="os-menu-item">Appearance</span> →
    <span class="os-menu-item">Navigation Bar</span>).


## IdeaVim customisations and settings

-   Ensure that the *.ideavimrc* configuration file from [my dotfiles][]
    is installed.
-   On macOS, make IdeaVim a more pleasant experience by running
    `defaults write com.jetbrains.PhpStorm ApplePressAndHoldEnabled -bool false`
    in the terminal.

  [my dotfiles]: <https://www.robotinaponcho.net/git/#toolbox>


## Miscellaneous customisations and settings

-   Check that PhpStorm is aware of all available PHP CLI interpreters
    in *Languages & Frameworks* → *PHP* in the *Settings* window.
-   Set the editor font to [Iosekva][] Term.
-   Set default visual guides at 72 and 78 characters.
-   Set the *Project Opening*’s *Default directory*.
-   Set the available language for the editor’s natural language gubbins
    to *English (Great Britain)*.
-   Turn on all *Refactoring opportunities* for the Default profile.
-   Turn off *Enable local Full Line completion suggestions*.

  [Iosekva]: <https://typeof.net/Iosevka/>
