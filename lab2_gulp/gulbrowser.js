const gulp = require('gulp');
const browserSync = require('browser-sync').create();

gulp.task('browser-sync', function() {
  browserSync.init({
    server: {
      baseDir: './'
    }
  });

  gulp.watch(['index.html', 'css/lab.css', 'js/lab.js']).on('change', browserSync.reload);
});

gulp.task('default', gulp.series('browser-sync'));
