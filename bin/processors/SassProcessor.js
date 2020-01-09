/* eslint-env node */

const autoprefixer = require('autoprefixer');
const CleanCSS = require('clean-css');
const postcss = require('postcss');
const sass = require('sass');

class SassProcessor {
  static get INPUT_EXTENSION() {
    return '.scss';
  }

  static get OUTPUT_EXTENSION() {
    return '.css';
  }

  // eslint-disable-next-line class-methods-use-this
  process(content, inputFile) {
    return postcss([autoprefixer]).process(
      sass.renderSync({ data: content }).css.toString(),
      { from: inputFile },
    )
      .then((postCSSOutput) => new CleanCSS().minify(postCSSOutput.css).styles);
  }
}

module.exports = SassProcessor;
