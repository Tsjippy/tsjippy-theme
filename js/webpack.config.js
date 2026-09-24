// webpack.config.js
const path = require('path');
const sharedAliases = require('../../../plugins/tsjippy-shared-functionality/js/webpack.aliases'); // Import your aliases

module.exports = {
  mode: 'production',
  devtool: 'source-map',
  // You can define all your files as entry points here
  entry: {
    customizer: './customizer.js',
    home: './home.js',
  },
  output: {
    module: true,
    path: path.resolve(__dirname, '.'),
    filename: '[name].min.js', // Automatically uses the entry key name (e.g., main.min.js)
  },
  resolve: {
    alias: {
        ...sharedAliases,
    },
  },
  experiments: {
    outputModule: true,
  },


  externalsType: 'module',
  externals,
};