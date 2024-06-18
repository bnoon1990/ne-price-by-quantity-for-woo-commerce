const gulp = require("gulp");
const cleanCSS = require("gulp-clean-css");
const concat = require("gulp-concat");
const uglify = require("gulp-uglify");
const clean = require("gulp-clean");
const composer = require("gulp-composer");
// const jsonEditor = require("gulp-json-editor");

gulp.task("minify-css-admin", function () {
  return gulp
    .src("src/styles/admin/**/*.css")
    .pipe(concat("admin.min.css"))
    .pipe(cleanCSS({ compatibility: "ie8" }))
    .pipe(gulp.dest("assets/css"));
});

gulp.task("minify-css-frontend", function () {
  return gulp
    .src("src/styles/frontend/**/*.css")
    .pipe(concat("frontend.min.css"))
    .pipe(cleanCSS({ compatibility: "ie8" }))
    .pipe(gulp.dest("assets/css"));
});

gulp.task("minify-js-admin", function () {
  return gulp
    .src("src/scripts/admin/**/*.js")
    .pipe(concat("admin.min.js"))
    .pipe(uglify())
    .pipe(gulp.dest("assets/js"));
});

gulp.task("minify-js-frontend", function () {
  return gulp
    .src("src/scripts/frontend/**/*.js")
    .pipe(concat("frontend.min.js"))
    .pipe(uglify())
    .pipe(gulp.dest("assets/js"));
});

gulp.task("watch", function () {
  gulp.watch("styles/admin/**/*.css", gulp.series("minify-css-admin"));
  gulp.watch("styles/frontend/**/*.css", gulp.series("minify-css-frontend"));
  gulp.watch("scripts/admin/**/*.js", gulp.series("minify-js-admin"));
  gulp.watch("scripts/frontend/**/*.js", gulp.series("minify-js-frontend"));
});

gulp.task(
  "default",
  gulp.series(
    "minify-css-admin",
    "minify-css-frontend",
    "minify-js-admin",
    "minify-js-frontend",
    "watch"
  )
);

gulp.task(
  "build",
  gulp.series(
    "minify-css-admin",
    "minify-css-frontend",
    "minify-js-admin",
    "minify-js-frontend"
  )
);

// Build task definitions

// Clean the build directory
gulp.task("clean-build", function () {
  return gulp.src("build", { allowEmpty: true }).pipe(clean());
});

// Copy necessary files to build directory
gulp.task("copy-files", function () {
  return gulp
    .src([
      "**/*.php", // Include PHP files in root
      "src/**/*.php", // Include PHP files in src directory
      "src/**/*.html", // Include HTML files in src directory
      "readme.txt", // Include readme.txt file in root
      "LICENSE.txt", // Include LICENSE file in root
      // "src/frontend/**/*.php", // Include PHP files in src/frontend directory
      // "src/admin/**/*.php", // Include PHP files in src/admin directory
      // "src/includes/**/*.php", // Include PHP files in src/includes directory
      // "assets/**", // Include assets directory from root
      "!node_modules/**",
      "!vendor/**",
      "!build/**",
      "!gulpfile.js",
      "!composer.json",
      "!composer.lock",
      "!package.json",
      "!package-lock.json",
      "!**/.git/**",
    ])
    .pipe(gulp.dest("build"));
});

// Copy screenshots to build/screenshots directory
gulp.task("copy-screenshots", function () {
  return gulp.src("src/screenshots/**/*").pipe(gulp.dest("build/screenshots"));
});

// Update composer to new autoload locations
// gulp.task("update-composer", function () {
//   return gulp
//     .src("./build/composer.json")
//     .pipe(
//       jsonEditor(function (json) {
//         json.autoload["psr-4"][
//           "Noonelite\\NePriceByQuantityForWoocommerce\\Admin\\"
//         ] = "admin/";
//         json.autoload["psr-4"][
//           "Noonelite\\NePriceByQuantityForWoocommerce\\Frontend\\"
//         ] = "frontend/";
//         json.autoload["psr-4"][
//           "Noonelite\\NePriceByQuantityForWoocommerce\\Includes\\"
//         ] = "includes/";
//         return json;
//       })
//     )
//     .pipe(gulp.dest("./build"));
// });

// Copy the assets directory
gulp.task("copy-assets", function () {
  return gulp.src("assets/**/*").pipe(gulp.dest("build/assets"));
});

// Copy composer.json and composer.lock to build directory
gulp.task("copy-composer-files", function () {
  return gulp.src(["composer.json", "composer.lock"]).pipe(gulp.dest("build"));
});

// Install composer autoload
gulp.task("composer-autoload", function (cb) {
  composer("dump-autoload", { "working-dir": "./build" });
  cb();
});

// Zip the build directory
gulp.task("zip-plugin", function () {
  return import("gulp-zip").then(({ default: zip }) => {
    return gulp
      .src("build/**/*")
      .pipe(zip("my-plugin.zip"))
      .pipe(gulp.dest("."));
  });
});

// Build task for production
gulp.task(
  "build",
  gulp.series(
    "clean-build",
    "minify-css-admin",
    "minify-css-frontend",
    "minify-js-admin",
    "minify-js-frontend",
    "copy-files",
    "copy-assets",
    "copy-composer-files",
    // "update-composer",
    "composer-autoload",
    "copy-screenshots"
    // "zip-plugin"
  )
);
