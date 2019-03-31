const path = require("path");
const HtmlWebpackPlugin = require("html-webpack-plugin");
const InterpolateHtmlPlugin = require("interpolate-html-plugin");
const CopyWebpackPlugin = require("copy-webpack-plugin");

// const ExtractTextPlugin = require('extract-text-webpack-plugin');
const Public_url = "/";
const PORT = 3000;
module.exports = {
  entry: "./src/App.js",
  output: {
    path: path.resolve(__dirname, "build"),
    filename: 'bundle.[hash:8].js',
    chunkFilename: '[name].[chunkhash].js',
    publicPath: "/"
  },
  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
        }
      },
      { 
        test: /\.(css|scss)$/, 
        use: [ 'style-loader', 'css-loader' ]},
      {
        test: /\.(png|jpeg|jpg|woff|woff2|eot|ttf|svg)$/,
        use: { loader: 'url-loader?limit=100000', }
      },
      // {
      //   test: /\.(ttf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
      //   loader: 'file-loader',
      // },
      {
        test: /\.html$/,
        use: [
          {
            loader: "html-loader",
            options: { minimize: false }
          }
        ]
      }

    ]
  },
  devServer: {
    port: PORT,
    historyApiFallback: {
      disableDotRule: true
    },
    contentBase: path.join(__dirname, '/build'),
    compress: true,
    clientLogLevel: 'info',
  },
  plugins: [
    new HtmlWebpackPlugin({
      template: "./public/index.html",
      inject: true
    }),
    new InterpolateHtmlPlugin({
      PUBLIC_URL: ''
    }),
    new CopyWebpackPlugin([
      { from: 'src/assets/', to: 'assets/' }
    ])
  ]

};
