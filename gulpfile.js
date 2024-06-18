import gulp from "gulp";
import cleanCSS from "gulp-clean-css";
import concat from "gulp-concat";
import uglify from "gulp-uglify";
import clean from "gulp-clean";
import composer from "gulp-composer";
import zip from "gulp-zip";
import fs from "fs";

gulp.task("minify-css-admin", () => {
  return gulp
    .src("src/styles/admin/**/*.css")
    .pipe(concat("admin.min.css"))
    .pipe(cleanCSS({ compatibility: "ie8" }))
    .pipe(gulp.dest("assets/css"));
});

gulp.task("minify-css-frontend", () => {
  return gulp
    .src("src/styles/frontend/**/*.css")
    .pipe(concat("frontend.min.css"))
    .pipe(cleanCSS({ compatibility: "ie8" }))
    .pipe(gulp.dest("assets/css"));
});

gulp.task("minify-js-admin", () => {
  return gulp
    .src("src/scripts/admin/**/*.js")
    .pipe(concat("admin.min.js"))
    .pipe(uglify())
    .pipe(gulp.dest("assets/js"));
});

gulp.task("minify-js-frontend", () => {
  return gulp
    .src("src/scripts/frontend/**/*.js")
    .pipe(concat("frontend.min.js"))
    .pipe(uglify())
    .pipe(gulp.dest("assets/js"));
});

gulp.task("watch", () => {
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
gulp.task("clean-build", () => {
  return gulp.src("build", { allowEmpty: true }).pipe(clean());
});

// Copy necessary files to build directory
gulp.task("copy-files", () => {
  return gulp
    .src([
      "**/*.php", // Include PHP files in root
      "src/**/*.php", // Include PHP files in src directory
      "src/**/*.html", // Include HTML files in src directory
      "readme.txt", // Include readme.txt file in root
      "LICENSE.txt", // Include LICENSE file in root
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
gulp.task("copy-screenshots", () => {
  return gulp.src("src/screenshots/**/*").pipe(gulp.dest("build/screenshots"));
});

// Copy the assets directory
gulp.task("copy-assets", () => {
  return gulp.src("assets/**/*").pipe(gulp.dest("build/assets"));
});

// Copy composer.json and composer.lock to build directory
gulp.task("copy-composer-files", () => {
  return gulp.src(["composer.json", "composer.lock"]).pipe(gulp.dest("build"));
});

// Install composer autoload
gulp.task("composer-autoload", function (cb) {
  composer("dump-autoload", { "working-dir": "./build", async: false });
  cb();
});

// Zip the build directory
gulp.task("zip-plugin", (done) => {
  fs.readFile("./ne-price-by-quantity.php", "utf8", function (err, data) {
    if (err) {
      return done(err);
    }

    var versionMatch = data.match(/Version:\s*(.*)/);
    if (!versionMatch) {
      return done(new Error("Could not find version in plugin file"));
    }

    var version = versionMatch[1];
    console.log("Creating zip for version " + version);

    return gulp
      .src("./build/**/*")
      .pipe(zip("ne-price-by-quantity-" + version + ".zip"))
      .pipe(gulp.dest("build"))
      .on("end", done);
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
    "composer-autoload",
    "copy-screenshots",
    "zip-plugin"
  )
);
