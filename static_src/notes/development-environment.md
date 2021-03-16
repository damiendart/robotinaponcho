<!--
  # This file is distributed under under the Creative Commons
  # Attribution 4.0 International License. To view a copy of this
  # license, please visit <http://creativecommons.org/licenses/by/4.0/>.

  description: Read Damien Dart's notes on setting up his development environment.
  title: Personal Development Environment Notes
  twigTemplate: .templates/notes-base.html.twig
-->

Setting up an Ubuntu Desktop 20.04 install
------------------------------------------

<div class="admonition admonition--info">
  <p><b>Note</b>: For reference, I'm currently running everything on an
    <a href="https://www.intel.co.uk/content/www/uk/en/products/boards-kits/nuc/kits/nuc10i7fnh.html">Intel
    NUC10i7FNH</a> with 32 GB of RAM. For web development and the other
    sorts of nerdery I do, it works for me just fine.
</div>

  - When installing Ubuntu on a machine that uses Secure Boot, **do not
    skip the key enrolment step on the initial reboot**. I have
    accidentally pressed _Continue_ without completing this step far too
    many times.
  - When logging in for the first time and after going through the
    welcome screen bumf, run the _Software Updater_.
  - Go through _Settings_ to see if anything needs attention.
  - Most of my environment setup is handled by [my Ansible gubbins][1],
    but there's a few things that need doing manually afterwards:
    - In Firefox: install the [1Password extension][2], change the
      default search engine to DuckDuckGo, and hide all the junk from
      the new tab screen. I also sign in to my Firefox account to get my
      bookmarks and whatnot.
    - Set the terminal font to [Iosevka][3].
    - Install [JetBrains Toolbox][4] and use it to install PhpStorm.
    - Connect to any network drives.
    - Set up Livepatch.
  - Set up a Windows VM in VirtualBox for cross-browser testing
    and the occasional piss-about in Visual Studio. (See _Setting up
    Windows in VirtualBox_ for more information.)

[1]: <https://www.robotinaponcho.net/git/#setup>
[2]: <https://1password.com/downloads/linux/#browsers>
[3]: <https://typeof.net/Iosevka/>
[4]: <https://www.jetbrains.com/help/phpstorm/installation-guide.html#toolbox>


Setting up Windows in VirtualBox
--------------------------------

  - As I only use the Windows VMs for cross-browser testing and
    occasional Visual Studio usage, I don't allocate that many resources
    to the virtual machine. I've found 50 GB of storage (in a
    dynamically-allocated virtual hard disk), 8 GB of memory, and four
    processors to be enough.
  - I haven't had great luck with turning on 3D acceleration.
  - When I can't be bothered setting up Windows, Microsoft provide
    [evaluation development environment virtual machines][5] that are
    good for doing some quick testing on. (Microsoft also provide
    [virtual machines][6] for testing websites in Internet Explorer 11
    and Edge Legacy.)
  - Manual steps to take after completing setup:
    - Update the hosts file (<span class="os-menu-item">%SystemRoot%\\<wbr>System32\\<wbr>drivers\\<wbr>etc\\<wbr>hosts</span>)
      to access websites hosted on the host.

[5]: <https://developer.microsoft.com/en-us/windows/downloads/virtual-machines/>
[6]: <https://developer.microsoft.com/en-us/microsoft-edge/tools/vms/>
