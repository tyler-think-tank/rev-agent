const path = require("path");
const glob = require("glob");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const WebpackShellPluginNext = require("webpack-shell-plugin-next");
const TerserPlugin = require("terser-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const CopyPlugin = require("copy-webpack-plugin");
const { exec } = require("child_process");

const mode = process.env.NODE_ENV || "development";
const isProduction = mode === "production";

const config = {
  mode: mode,
  entry: () => {
    const scssFiles = glob.sync("./blocks/**/*.scss");
    const resourceScssFiles = glob.sync("./resources/scss/**/*.scss");
    const jsFiles = glob.sync("./blocks/**/*.js");
    const resourceJsFiles = glob.sync("./resources/js/**/*.js");
    const entries = {};

    scssFiles.forEach((scssFile) => {
      const entry = scssFile
        .replace(".scss", "")
        .replace("./blocks/", "assets/css/");
      entries[entry] = scssFile;
    });

    resourceScssFiles.forEach((scssFile) => {
      if (!/\/_/.test(scssFile)) {
        const entry = scssFile
          .replace(".scss", "")
          .replace("./resources/scss/", "assets/css/");
        entries[entry] = scssFile;
      }
    });

    jsFiles.forEach((jsFile) => {
      const entry = jsFile
        .replace(".js", "")
        .replace("./blocks/", "assets/js/");
      entries[entry] = jsFile;
    });

    resourceJsFiles.forEach((jsFile) => {
      if (!/\/_/.test(jsFile)) {
        const entry = jsFile
          .replace(".js", "")
          .replace("./resources/js/", "assets/js/");
        entries[entry] = jsFile;
      }
    });

    return entries;
  },
  output: {
    filename: "[name].js",
    path: path.resolve(__dirname, "dist"),
  },
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          "css-loader",
          "postcss-loader", // Added this line for PostCSS
          "sass-loader",
        ],
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env"],
          },
        },
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "[name].css",
    }),
    new CopyPlugin({
      patterns: [{ from: "resources/images", to: "assets/images" }],
    }),
  ],
  optimization: {
    emitOnErrors: true,
    minimize: isProduction,
    minimizer: [new TerserPlugin(), new CssMinimizerPlugin()],
  },
  externals: {
    jquery: "jQuery",
  },
};

class AfterEmitPlugin {
  apply(compiler) {
    compiler.hooks.afterEmit.tapAsync(
      "AfterEmitPlugin",
      (compilation, callback) => {
        exec("node helpers/generate-acf-blocks.js", (err, stdout, stderr) => {
          if (stdout) process.stdout.write(stdout);
          if (stderr) process.stderr.write(stderr);
          callback();
        });
      }
    );
  }
}

class RemoveEmptyJSFiles {
  apply(compiler) {
    compiler.hooks.emit.tapAsync(
      "RemoveEmptyJSFiles",
      (compilation, callback) => {
        Object.keys(compilation.assets).forEach((assetName) => {
          if (/\.js$/.test(assetName) && /^assets\/css\//.test(assetName)) {
            delete compilation.assets[assetName];
          }
        });
        callback();
      }
    );
  }
}

config.plugins.push(new RemoveEmptyJSFiles());
config.plugins.push(new AfterEmitPlugin());

module.exports = config;
