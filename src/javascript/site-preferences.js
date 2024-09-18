// Copyright (C) Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

class SitePreferencesDialog extends HTMLElement {
  connectedCallback() {
    let currentTheme = SitePreferencesDialog.getCurrentTheme();
    const themes = {
      auto: 'Use system setting',
      light: 'Light theme',
      dark: 'Dark theme',
    };

    this.innerHTML = `
        <button id="open-preferences-dialog" type="button">Preferences</button>
        <dialog class="dialog">
          <form method="dialog">
            <div class="dialog__header">
              <button autofocus class="dialog__close" formmethod="dialog" value="cancel"><span class="u-visually-hidden">Cancel</span></button>
              <hr aria-hidden="true">
              <h1 class="h3">Preferences</h2>
            </div>
            <div class="dialog__body u-stack">
              <p>Your preferences will be saved locally. For more information, see the <a href="/privacy-policy">privacy policy</a>.</p>
              <fieldset class="u-stack">
                <legend>Site theme</legend>
                ${
                  Object
                    .keys(themes)
                    .map(
                      (key) => `
                        <label class="has-input-radio">
                          <input id="theme-${key}" name="theme" type="radio" value="${key}" ${currentTheme === key ? 'checked' : ''}>
                          <strong>${themes[key]}</strong>
                        </label>
                      `,
                    )
                    .join('')
                }
              </fieldset>
            </div>
            <div class="dialog__footer">
              <button class="button button--small" formmethod="dialog" value="cancel">Cancel</button>
              <button class="button button--small">Save</button>
            </div>
          </form>
        </dialog>
    `;

    this.addEventListener(
      'click',
      (event) => {
        if (event.target.closest('#open-preferences-dialog')) {
          currentTheme = SitePreferencesDialog.getCurrentTheme();
          this.querySelector('dialog').showModal();
        }

        if (event.target.closest('button[value="cancel"]')) {
          event.preventDefault();

          SitePreferencesDialog.setCurrentTheme(currentTheme);

          this.querySelector('dialog').close();
          this.querySelectorAll('input[name="theme"]')
            .forEach(
              (element) => element.checked = element.value === currentTheme,
            );
        }
      },
    );

    this.addEventListener(
      'change',
      (event) => {
        SitePreferencesDialog.setCurrentTheme(event.target.value);
      },
    );
  }

  static getCurrentTheme() {
    return localStorage.getItem('theme') || 'auto';
  }

  static setCurrentTheme(theme) {
    if (theme === 'auto' || theme === null) {
      delete document.documentElement.dataset.theme;
      localStorage.removeItem('theme');
    } else {
      document.documentElement.dataset.theme = theme;
      localStorage.setItem('theme', theme);
    }
  }
}

window.addEventListener(
  'storage',
  (event) => {
    if (event.key === 'theme') {
      SitePreferencesDialog.setCurrentTheme(
        SitePreferencesDialog.getCurrentTheme(),
      );
    }
  },
);

const siteFooterNavigationItem = document.createElement('li');

customElements.define('site-preferences-dialog', SitePreferencesDialog);

siteFooterNavigationItem.appendChild(
  document.createElement('site-preferences-dialog'),
);

document
  .querySelector('.site-footer__navigation__list')
  .appendChild(siteFooterNavigationItem);
document
  .querySelector('[href="#footer"]')
  .innerHTML += ' and site preferences';
