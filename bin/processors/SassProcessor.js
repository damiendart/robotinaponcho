const autoprefixer = require('autoprefixer');
const cleanCSS = require('clean-css');
const postcss = require('postcss');
const sass = require('sass');

class SassProcessor
{
  static get INPUT_EXTENSION()
  {
    return '.scss';
  }

  static get OUTPUT_EXTENSION()
  {
    return '.css';
  }

  process(content, inputFile, outputFile)
  {
    return postcss([autoprefixer]).process(
      sass.renderSync({ data: content }).css.toString(),
      { from: inputFile }
    )
      .then(postCSSOutput => new cleanCSS().minify(postCSSOutput.css).styles);
  }
}

module.exports = SassProcessor;