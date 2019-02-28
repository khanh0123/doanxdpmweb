var path = require('path');
// var webpack = require('webpack');
var HtmlWebpackPlugin = require('html-webpack-plugin');
const InterpolateHtmlPlugin = require("interpolate-html-plugin");
const CopyWebpackPlugin = require("copy-webpack-plugin");
const uglifyJsContents = require('uglify-js');
const uglifyCssContents = require('uglifycss');
const CleanWebpackPlugin = require('clean-webpack-plugin')
let is_minimize = false;

module.exports = {
  entry: [
    path.join(__dirname, './src', 'client.js')
  ],
  output: {
    path: path.join(__dirname, './build'),
    filename: 'bundle.[hash:16].js',
    publicPath: '/'
  },
  plugins: [
    new CleanWebpackPlugin(['build'], {
      root: process.cwd(),
      verbose: true,
      dry: false
    }),
    new HtmlWebpackPlugin({
      inject: true,
      template: path.join(__dirname, './public/index.html'),
      minify: {
        removeComments: true,
        collapseWhitespace: true,
        removeRedundantAttributes: true,
        useShortDoctype: true,
        removeEmptyAttributes: true,
        removeStyleLinkTypeAttributes: true,
        keepClosingSlash: true,
        minifyJS: true,
        minifyCSS: true,
        minifyURLs: true,
      },
    }),
    // new InterpolateHtmlPlugin({
    //   PUBLIC_URL: ''
    // }),

    new CopyWebpackPlugin([{
      from: 'src/assets/',
      to: '',
    //   transform: function (fileContent, path) {
    //     if (!is_minimize) {
    //       console.log(`Running copy assets folders with minimize ...`);
    //       is_minimize = true;
    //     }
    //     let regJS = /\.js$/gi;
    //     let regCSS = /\.css$/gi;
    //     if (regJS.test(path)) {
    //       try {
    //         return path.indexOf(".min.js") == -1 ? uglifyJsContents.minify(fileContent.toString()).code.toString() : fileContent;
    //       } catch (error) {
    //         return fileContent;
    //       }

    //     }

    //     if (regCSS.test(path)) {
    //       return uglifyCssContents.processFiles(
    //         [path],
    //         { maxLineLen: 500, expandVars: true }
    //       );
    //     }

    //     return fileContent;

    //   }
    }])
  ],

  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader"
        }
      },
      {
        test: /\.css$/,
        use: ['style-loader', 'css-loader']
      },
      {
        test: /\.(png|jpeg|jpg|woff|woff2|eot|ttf|svg)$/,
        use: { loader: 'url-loader?limit=100000', }
      },
      {
        //   test: /\.(ttf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
        //   loader: 'file-loader',
        // },
        // {
        test: /\.html$/,
        use: [
          {
            loader: "html-loader",
            options: { minimize: true }
          }
        ]
      }

    ]
  },
};