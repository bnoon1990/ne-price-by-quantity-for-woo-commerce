const gulp = require("gulp");
const cleanCSS = require("gulp-clean-css");
const concat = require("gulp-concat");

gulp.task("minify-css-admin", function () {
  return gulp
    .src("styles/admin/**/*.css")
    .pipe(concat("admin.css"))
    .pipe(cleanCSS({ compatibility: "ie8" }))
    .pipe(gulp.dest("dist"));
});

gulp.task("minify-css-frontend", function () {
  return gulp
    .src("styles/frontend/**/*.css")
    .pipe(concat("frontend.css"))
    .pipe(cleanCSS({ compatibility: "ie8" }))
    .pipe(gulp.dest("dist"));
});

gulp.task("watch", function () {
  gulp.watch("styles/admin/**/*.css", gulp.series("minify-css-admin"));
  gulp.watch("styles/frontend/**/*.css", gulp.series("minify-css-frontend"));
});

gulp.task(
  "default",
  gulp.series("minify-css-admin", "minify-css-frontend", "watch")
);
