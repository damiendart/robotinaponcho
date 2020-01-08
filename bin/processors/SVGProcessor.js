const svgo = require('svgo');

class SVGProcessor
{
    static get INPUT_EXTENSION()
    {
        return '.svg';
    }

    static get OUTPUT_EXTENSION()
    {
        return this.INPUT_EXTENSION;
    }

    process(content, inputFile, outputFile)
    {
        return new svgo().optimize(content).then(output => output.data);
    }
}

module.exports = SVGProcessor;