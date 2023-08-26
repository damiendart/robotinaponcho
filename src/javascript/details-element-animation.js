// Copyright (C) Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

class DetailsElementAnimation {
  constructor(element) {
    this.animation = null;
    this.containerElement = element;
    this.mainContentElement = element.querySelector('div');
    this.summaryElement = element.querySelector('summary');

    this.containerElement.setAttribute('data-animation-state', 'idle');

    this.summaryElement.addEventListener(
      'click',
      (event) => {
        if (event.target.closest('a')) {
          return;
        }

        event.preventDefault();

        this.containerElement.style.overflow = 'hidden';

        if (
          this.containerElement.getAttribute('data-animation-state') === 'closing'
          || !this.containerElement.open
        ) {
          this.open();
        } else if (
          this.containerElement.getAttribute('data-animation-state') === 'opening'
          || this.containerElement.open
        ) {
          this.close();
        }
      },
    );
  }

  close() {
    this.containerElement.setAttribute('data-animation-state', 'closing');

    if (this.animation) {
      this.animation.cancel();
    }

    this.animation = this.containerElement.animate(
      {
        height: [
          `${this.containerElement.offsetHeight}px`,
          `${this.summaryElement.offsetHeight}px`,
        ],
      },
      {
        delay: 250,
        duration: 250,
        easing: 'ease',
      },
    );
    this.animation.onfinish = () => this.onAnimationFinish(false);
    this.animation.oncancel = () => this.containerElement.setAttribute(
      'data-animation-state',
      'idle',
    );
  }

  open() {
    this.containerElement.style.height = `${this.containerElement.offsetHeight}px`;
    this.containerElement.open = true;

    window.requestAnimationFrame(
      () => {
        this.containerElement.setAttribute('data-animation-state', 'opening');

        if (this.animation) {
          this.animation.cancel();
        }

        this.animation = this.containerElement.animate(
          {
            height: [
              `${this.containerElement.offsetHeight}px`,
              `${this.summaryElement.offsetHeight + this.mainContentElement.offsetHeight}px`,
            ],
          },
          { duration: 250, easing: 'ease' },
        );
        this.animation.onfinish = () => this.onAnimationFinish(true);
        this.animation.oncancel = () => this.containerElement.setAttribute(
          'data-animation-state',
          'idle',
        );
      },
    );
  }

  onAnimationFinish(isOpen) {
    this.animation = null;
    this.containerElement.open = isOpen;
    this.containerElement.setAttribute('data-animation-state', 'idle');
    this.containerElement.style.height = '';
    this.containerElement.style.overflow = '';
  }
}

document.querySelectorAll('details').forEach(
  (el) => {
    // eslint-disable-next-line no-new
    new DetailsElementAnimation(el);
  },
);
