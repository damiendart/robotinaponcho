<!--
  # This file is distributed under the Creative Commons Attribution 4.0
  # International License. To view a copy of this license, please visit
  # <http://creativecommons.org/licenses/by/4.0/>.

  description: Read Damien Dart's notes on setting up his development environment.
  title: Personal Development Environment Notes
  twigTemplate: .templates/base-note.html.twig
-->

For reference, I'm currently using an
<a href="https://www.intel.co.uk/content/www/uk/en/products/boards-kits/nuc/kits/nuc10i7fnh.html">Intel
NUC10i7FNH</a> with 32 GB of RAM which, for web development and the
other sorts of nerdery I do, works for me just fine.


Setting up an Ubuntu Desktop 20.04 install
------------------------------------------

  - When installing Ubuntu on a machine that uses Secure Boot, **do not
    skip the key enrolment step on the initial reboot**. I have
    accidentally pressed _Continue_ without completing this step far too
    many times.
  - When logging in for the first time and after going through the
    welcome screen bumf, run the _Software Updater_.
  - Go through _Settings_ to see if anything needs attention.
  - Most of my environment setup is handled by [my Ansible gubbins][1],
    but there's still a few steps that need doing manually afterwards:
    - Fix a bug in the Dash to Dock Gnome Shell extension that causes
      [icons to take ages to update][2] when you start with an empty
      dock by manually applying a fix [available on GitHub][3] (to
      <span class="os-menu-item">/usr/<wbr>share/<wbr>gnome-shell/<wbr>extensions/<wbr>ubuntu-dock\@ubuntu.com/<wbr>dash.js</span>).
    - In Firefox: install the [1Password extension][4], change the
      default search engine to DuckDuckGo, and hide all the junk from
      the new tab screen. I also sign in to my Firefox account to get my
      bookmarks and whatnot.
    - To handle Terraform secrets, find and copy over any existing GnuPG
      bits-and-pieces (as far as I can tell, all you need is
      _pubring.gpg_, _secring.gpg_, and _trustdb.gpg_).
    - Set the terminal font to [Iosevka][5] (which should be already
      installed by the provisioning Ansible playbook).
    - Install [JetBrains Toolbox][6] and use it to install PhpStorm (see
      also: [my PhpStorm notes][7]).
    - Install [Steam][8].
    - Connect to any network drives.
    - Set up Livepatch, Syncthing, and Obsidian.
  - Set up Windows 10 VMs in VirtualBox for cross-browser testing, and
    the occasional piss-about in Creative Cloud and Visual Studio. (See
    _Setting up Windows 10 in VirtualBox_ for more information.)

[1]: <https://www.robotinaponcho.net/git/#setup>
[2]: <https://github.com/micheleg/dash-to-dock/issues/1188>
[3]: <https://github.com/micheleg/dash-to-dock/pull/1222/commits/3c44ea483f333fef12e6a805cd43d2a2439e5fb0>
[4]: <https://1password.com/downloads/linux/#browsers>
[5]: <https://typeof.net/Iosevka/>
[6]: <https://www.jetbrains.com/help/phpstorm/installation-guide.html#toolbox>
[7]: <https://www.robotinaponcho.net/notes/phpstorm>
[8]: <https://github.com/ValveSoftware/steam-for-linux>


Setting up Windows 10 in VirtualBox
-----------------------------------

I mainly use Windows 10 VMs for cross-browser testing, and occasional
Creative Cloud and Visual Studio usage, so I don't spend too much time
with customisation and maintenance.

  - When installing Windows 10 from scratch, I've found allocating 50 GB
    of storage (in a dynamically-allocated virtual hard disk), 8 GB of
    memory, and four processors to be enough for my use cases.
  - Enable 3D acceleration with the maximum amount of available video
    memory allocated. However, this causes some [hardcore funkiness][9].
    Turning [transparency effects off in Windows][10] helps a little,
    but things like Photoshop are still a little funky.
  - Once the initial installation is complete and updates are installed:
    - Install the VirtualBox Guest Additions.
    - Set the screen resolution (<span class="os-menu-item">View</span>
      &rarr; <span class="os-menu-item">Virtual Screen 1</span>) to
      1600×900, or the largest resolution that'll fit on-screen.
    - Install Creative Cloud. (As my little Intel NUC doesn't have that
      much video memory to spare, I'm limited to what I can do.
      Fortunately, I have Creative Cloud available on another machine to
      fall back on.)
    - Update the hosts file (<span class="os-menu-item">%SystemRoot%\\<wbr>System32\\<wbr>drivers\\<wbr>etc\\<wbr>hosts</span>)
      to [access websites and other network services on the host][11].

I only use Visual Studio for working on [FlippyWindow][12]; Microsoft
provide [evaluation development environment virtual machines][13] that
are perfect for the small amounts of Visual-Studio-ing that I do.
(Microsoft also provide [virtual machines][14] for testing websites in
Internet Explorer 11 and Edge Legacy.)

[9]: <https://www.virtualbox.org/attachment/ticket/19365/VirtualBox_Windows%2010_03_06_2020_21_55_02.png>
[10]: <https://www.virtualbox.org/ticket/19365#comment:16>
[11]: <http://www.virtualbox.org/manual/ch06.html#network_nat>
[12]: <https://www.robotinaponcho.net/flippywindow/>
[13]: <https://developer.microsoft.com/en-us/windows/downloads/virtual-machines/>
[14]: <https://developer.microsoft.com/en-us/microsoft-edge/tools/vms/>
