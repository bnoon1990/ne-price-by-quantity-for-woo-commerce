const gulp = require("gulp");
const cleanCSS = require("gulp-clean-css");
const concat = require("gulp-concat");

gulp.task("minify-css", function () {
  return gulp
    .src("styles/**/*.css")
    .pipe(concat("styles.css"))
    .pipe(cleanCSS({ compatibility: "ie8" }))
    .pipe(gulp.dest("dist"));
});

gulp.task("watch", function () {
  gulp.watch("styles/**/*.css", gulp.series("minify-css"));
});

gulp.task("default", gulp.series("minify-css", "watch"));
