/* eslint-env node */

const SVGO = require('svgo');

class SVGProcessor {
  static get INPUT_EXTENSION() {
    return '.svg';
  }

  static get OUTPUT_EXTENSION() {
    return this.INPUT_EXTENSION;
  }

  // eslint-disable-next-line class-methods-use-this
  process(content) {
    return new SVGO().optimize(content).then((output) => output.data);
  }
}

module.exports = SVGProcessor;
