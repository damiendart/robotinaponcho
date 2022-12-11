<!---
  # This file is distributed under the Creative Commons Attribution 4.0
  # International License. To view a copy of this license, please visit
  # <http://creativecommons.org/licenses/by/4.0/>.

  collections:
    - 'notes'
    - 'ubuntu'
  twigTemplate: .templates/base-note.html.twig
--->

Setting Up an Ubuntu Desktop 20.04 Install
==========================================

For reference, I’m currently using an [Intel NUC10i7FNH][] with 32 GB of
RAM.

  [Intel NUC10i7FNH]: <https://www.intel.co.uk/content/www/uk/en/products/boards-kits/nuc/kits/nuc10i7fnh.html>


## Operating system installation and the first five minutes

- When installing Ubuntu on a machine that uses Secure Boot, **do not
  skip the key enrolment step on the initial reboot**. I have
  accidentally pressed *Continue* without completing this step far too
  many times.
- After going through the welcome screen bumf, I tend to run the
  *Software Updater* and go through *Settings*. (I am cursed with being
  incapable of using any new thing unless I’ve thoroughly scoured its
  options and settings.)
- Set up and run the provisioning Ansible playbook available from [my
  Ansible gubbins][].

  [my Ansible gubbins]: <https://www.robotinaponcho.net/git/#setup>


## Post-Ansible checklist and tasks

While most of my machine provisioning is handled by Ansible, I haven’t
managed to automate everything:

- Fix [a bug in the Dash to Dock GNOME Shell extension][] that causes
  icons to take ages to update when you start with an empty dock by
  manually applying [a fix available on GitHub][] to <span
  class="os-menu-item">/usr/<wbr>share/<wbr>gnome-shell/<wbr>extensions/<wbr>ubuntu-dock@ubuntu.com/<wbr>dash.js</span>.
- In Firefox: install the [1Password extension][], change the default
  search engine to DuckDuckGo, and hide all the junk from the new tab
  screen. I also sign in to my Firefox account to get my bookmarks and
  whatnot.
- To be able to use Terraform secrets, find and copy over any existing
  GnuPG bits-and-pieces (as far as I can tell, all you need is
  *pubring.gpg*, *secring.gpg*, and *trustdb.gpg*).
- Set the terminal font to [Iosevka][] Term (which should be already
  installed by the provisioning Ansible playbook).
- Install [JetBrains Toolbox][] and use it to install GoLand and
  PhpStorm (see also [my PhpStorm notes][]).
- Install [Steam][].
- Connect to any network drives.
- Set up Livepatch, Syncthing, and Obsidian.
- Set up some Windows 10 VMs in VirtualBox for cross-browser testing and
  light Visual Studio usage.
  - While I’ve got a valid Windows 10 licence kicking about, Microsoft
    provide [evaluation development environment virtual machines][] that
    are perfect for how often I need to use Windows. (Microsoft also
    provide [virtual machines][] for testing websites in Internet
    Explorer 11 and Edge Legacy.)
  - Remember to update the hosts file (<span
    class="os-menu-item">%SystemRoot%\\<wbr>System32\\<wbr>drivers\\<wbr>etc\\<wbr>hosts</span>)
    to [access websites and other network services on the host][].

  [a bug in the Dash to Dock GNOME Shell extension]: <https://github.com/micheleg/dash-to-dock/issues/1188>
  [a fix available on GitHub]: <https://github.com/micheleg/dash-to-dock/pull/1222/commits/3c44ea483f333fef12e6a805cd43d2a2439e5fb0>
  [1Password extension]: <https://1password.com/downloads/linux/#browsers>
  [Iosevka]: <https://typeof.net/Iosevka/>
  [JetBrains Toolbox]: <https://www.jetbrains.com/help/phpstorm/installation-guide.html#toolbox>
  [my PhpStorm notes]: <https://www.robotinaponcho.net/notes/phpstorm>
  [Steam]: <https://github.com/ValveSoftware/steam-for-linux>
  [evaluation development environment virtual machines]: <https://developer.microsoft.com/en-us/windows/downloads/virtual-machines/>
  [virtual machines]: <https://developer.microsoft.com/en-us/microsoft-edge/tools/vms/>
  [access websites and other network services on the host]: <http://www.virtualbox.org/manual/ch06.html#network_nat>
