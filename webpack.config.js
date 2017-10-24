const path = require("path");
const webpack = require('webpack');

module.exports = function(env) {
  return {
    entry: {
      admin: "./admin/js/admin.js",
      public: "./pub/js/public.js"
    }, 
    output: {
      path: path.join(__dirname, "/dist"),
      filename: "[name].js"
    },
    module: {
      rules: [
        {
          test: /\.js$/, //Check for all js files
          loader: 'babel-loader',
          query: {
            presets: [ "babel-preset-es2015" ].map(require.resolve)
          }
        }
      ]
    },
    module: {
      rules: [{
        test: /\.(sass|scss)$/, //Check for sass or scss file names
        use: [
          'style-loader',
          'css-loader',
          'sass-loader',
        ]
      }]
    },
  }
}