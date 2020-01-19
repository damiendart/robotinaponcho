/* eslint-env node */

const babel = require('@babel/core');
const browserify = require('browserify');
const stream = require('stream');
const uglifyJS = require('uglify-js');

class JavaScriptProcessor {
  static get INPUT_EXTENSION() {
    return '.js';
  }

  static get OUTPUT_EXTENSION() {
    return this.INPUT_EXTENSION;
  }

  // eslint-disable-next-line class-methods-use-this
  process(content, inputFile) {
    return new Promise((resolve, reject) => {
      browserify()
        .add(inputFile)
        .transform((file) => {
          const chunks = [];

          return new stream.Transform({
            flush(callback) {
              babel.transform(
                Buffer.concat(chunks).toString(),
                { filename: file, presets: ['@babel/preset-env'] },
                (err, result) => {
                  if (err) {
                    callback(err);
                  } else {
                    callback(null, result.code);
                  }
                },
              );
            },
            transform(chunk, encoding, callback) {
              chunks.push(chunk);
              callback();
            },
          });
        })
        .bundle((err, result) => {
          if (err) {
            reject(err);
          } else {
            resolve(result.toString());
          }
        });
    })
      .then((bundle) => uglifyJS.minify(bundle).code);
  }
}

module.exports = JavaScriptProcessor;
