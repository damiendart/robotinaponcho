/* eslint-env node */

const { minify } = require('html-minifier');
const { promisify } = require('util');
const { TwingEnvironment, TwingFilter, TwingLoaderRelativeFilesystem } = require('twing');

const exec = promisify(require('child_process').exec);
const marked = require('marked');

class TwigProcessor {
  static get INPUT_EXTENSION() {
    return '.twig';
  }

  static get OUTPUT_EXTENSION() {
    return '';
  }

  constructor() {
    this.twingEnvironment = new TwingEnvironment(
      new TwingLoaderRelativeFilesystem(),
      { strict_variables: true },
    );

    this.twingEnvironment.addFilter(
      new TwingFilter(
        'markdown',
        (markup) => {
          const markdown = markup.toString();
          const indentation = markdown.match(/^\s*/);
          const indentationRegex = new RegExp(
            `^${indentation && indentation.length}` ? indentation[0] : '',
          );

          return marked(
            markdown.split(/\r?\n/).reduce(
              (carry, line) => `${carry}${line.replace(indentationRegex, '')}\n`,
              '',
            ),
            { headerIds: false, smartypants: true },
          );
        },
        { is_safe: ['html'] },
      ),
    );
  }

  process(content, inputFile) {
    return exec(`git log -n 1 --pretty=format:'%H %at' ${inputFile}`)
      .then((gitOutput) => new Promise((resolve) => {
        const [gitHash, modified] = gitOutput.stdout.split(' ');
        const template = this.twingEnvironment.load(inputFile);

        resolve(template.render({
          gitHash,
          modified: new Date(parseInt(modified, 10)),
        }));
      }))
      .then((html) => minify(html,
        {
          collapseWhitespace: true,
          decodeEntities: true,
          minifyJS: true,
          removeComments: true,
          removeEmptyAttributes: true,
        }));
  }
}

module.exports = TwigProcessor;
