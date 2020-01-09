/* eslint-env node */

const lodash = require('lodash');
const path = require('path');
const rollup = require('rollup');
const rollupUglify = require('rollup-plugin-uglify');

class JavaScriptProcessor {
  static get INPUT_EXTENSION() {
    return '.js';
  }

  static get OUTPUT_EXTENSION() {
    return this.INPUT_EXTENSION;
  }

  // eslint-disable-next-line class-methods-use-this
  process(content, inputFile, outputFile) {
    return rollup.rollup({ input: inputFile, plugins: [rollupUglify.uglify()] })
      .then((bundle) => bundle.generate({
        file: outputFile,
        format: 'iife',
        name: path.basename(outputFile) !== 'app.js'
          ? lodash.camelCase(path.basename(outputFile, '.js'))
          : null,
        sourcemap: false,
      })
        .then((output) => output.output[0].code));
  }
}

module.exports = JavaScriptProcessor;
