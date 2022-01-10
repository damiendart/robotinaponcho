// Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

class ThemeSwitcher {
  constructor(element) {
    this.containerElement = element;
    this.themeSelectElement = document.createElement('select');

    this.initialiseThemeSwitcher();
  }

  initialiseThemeSwitcher() {
    const currentTheme = ThemeSwitcher.getCurrentTheme();
    const themes = {
      auto: 'Default theme',
      dark: 'Dark theme',
      light: 'Light theme',
    };

    this.themeSelectElement.setAttribute('aria-label', 'Change site theme');
    Object.keys(themes).forEach(
      (themeSlug) => {
        const optionElement = document.createElement('option');
        optionElement.value = themeSlug;
        optionElement.innerText = themes[themeSlug];

        if (currentTheme === themeSlug) {
          optionElement.selected = true;
        }

        this.themeSelectElement.appendChild(optionElement);
      },
    );

    this.containerElement.appendChild(this.themeSelectElement);

    this.themeSelectElement.addEventListener(
      'change',
      (event) => {
        this.setCurrentTheme(event.target.value);
      },
    );
  }

  setCurrentTheme(theme) {
    if (theme === 'auto' || theme === null) {
      delete document.documentElement.dataset.theme;
      localStorage.removeItem('theme');
    } else {
      document.documentElement.dataset.theme = theme;
      localStorage.setItem('theme', theme);
    }

    this.updateThemeSwitcher(theme);
  }

  updateThemeSwitcher(theme) {
    Array.prototype.forEach.call(
      this.themeSelectElement.querySelectorAll('option'),
      (element) => {
        // eslint-disable-next-line no-param-reassign
        element.selected = (element.value === theme);
      },
    );
  }

  static getCurrentTheme() {
    if (localStorage.getItem('theme')) {
      return localStorage.getItem('theme');
    }

    return 'auto';
  }
}

export default ThemeSwitcher;