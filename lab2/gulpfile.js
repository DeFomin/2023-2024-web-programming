const gulp = require('gulp');
const opn = require('opn');

const pages = [
  'https://github.com',          
  'https://habr.com',            
  'https://stackoverflow.com',   
];

const interval = 5000; 

currentPageIndex = 0;

function showNextPage() {
  if (currentPageIndex < pages.length) {
    opn(pages[currentPageIndex]).catch(error => {
      console.error(`Error opening page: ${error}`);
    });
    currentPageIndex++;
    }
  }

gulp.task('show-pages', function (done) {
  setInterval(showNextPage, interval);

  done(); 
});

gulp.task('default', gulp.series('show-pages'));

