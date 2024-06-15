const gulp = require("gulp");
const cleanCSS = require("gulp-clean-css");
const concat = require("gulp-concat");
const uglify = require("gulp-uglify");

gulp.task("minify-css-admin", function () {
  return gulp
    .src("styles/admin/**/*.css")
    .pipe(concat("admin.min.css"))
    .pipe(cleanCSS({ compatibility: "ie8" }))
    .pipe(gulp.dest("dist"));
});

gulp.task("minify-css-frontend", function () {
  return gulp
    .src("styles/frontend/**/*.css")
    .pipe(concat("frontend.min.css"))
    .pipe(cleanCSS({ compatibility: "ie8" }))
    .pipe(gulp.dest("dist"));
});

gulp.task("minify-js-admin", function () {
  return gulp
    .src("scripts/admin/**/*.js")
    .pipe(concat("admin.min.js"))
    .pipe(uglify())
    .pipe(gulp.dest("dist"));
});

gulp.task("minify-js-frontend", function () {
  return gulp
    .src("scripts/frontend/**/*.js")
    .pipe(concat("frontend.min.js"))
    .pipe(uglify())
    .pipe(gulp.dest("dist"));
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
