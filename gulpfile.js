var gulp = require('gulp');
var elixir = require('laravel-elixir');
var concat = require('gulp-concat');
var compass = require('gulp-compass');
var filter = require('gulp-filter');
var mainBowerFiles = require('main-bower-files');
var browserSync = require('browser-sync');
var order = require("gulp-order");
var uglify = require('gulp-uglify');
var notify = require("gulp-notify");
var jshint = require('gulp-jshint');

 /**
  * Lauch a live reload server
  *
  */
 gulp.task('browser-sync', function() {
 	browserSync({
        proxy: "softjob.app",       
    });
 });

 gulp.task('reload', function() {
 	browserSync.reload();
 });


/**
 * Laravel specific tasks
 *
 */
 // gulp.task('laravel', function() {
 // 	elixir(function(mix) {
	// 	mix.events().routes();
	// });
 // });

/**
 * Compile sass files using compass and minify generated css
 *
 */
 gulp.task('compass', function() {
 	gulp.src('./resources/assets/sass/*.scss')
 		.pipe(compass({
 			config_file: './config.rb',
 			css: 'public/dist',
 			sass: 'resources/assets/sass'
 		}))
 		.pipe(gulp.dest('./public/dist'))
 		.pipe(notify('sass compiled'));
 		// .pipe(browserSync.reload({stream:true}));
 });


/**
 * Merge and uglify js files
 *
 */
 gulp.task('js', function() {
 	var files = ['./public/js/modules.js', './public/js/services/*.js', './public/js/controllers/*.js', './public/js/directives/*.js', './public/js/intl.js'];
 	for (var i = files.length - 1; i >= 0; i--) {

 		gulp.src(files[i])
 			.pipe(jshint('.jshintrc'))
 			.pipe(jshint.reporter('jshint-stylish'));
 	};
 	gulp.src(files)
 		.pipe(concat('app.js', {newLine: '\r\n'})) 		
 		// .pipe(uglify())
 		.pipe(gulp.dest('./public/dist'))
 		.pipe(notify("js compiled"));
 });


/**
 * Filter and merge bower dependencies
 *
 */
var filterByExtension = function(extension){
	return filter(function(file){
		return file.path.match(new RegExp('.' + extension + '$'));
	});
};

gulp.task('bower', function(){
	var mainFiles = mainBowerFiles();
	if(!mainFiles.length){
		return;
	}
	var jsFilter = filterByExtension('js');

	return gulp.src(mainFiles)
		.pipe(jsFilter)
		.pipe(concat('lib.js'))
		// .pipe(uglify())
		.pipe(gulp.dest('./public/dist'))
		.pipe(jsFilter.restore())
		.pipe(filterByExtension('css'))
		.pipe(concat('lib.css'))
		.pipe(gulp.dest('./public/dist'))
		.pipe(notify('bower files are ready'));
});

 /**
 * Watch for file changes and fire appropriate actions
 *
 */
gulp.task('watch', function() {
	gulp.watch('resources/assets/sass/**/*.scss', ['compass']);		
	gulp.watch('public/js/**/*.js', ['js']);		
	// gulp.watch('./public/**/*.html', ['reload']);
	// gulp.watch('./app/*.php', ['laravel']);		
	gulp.watch('bower.json', ['bower']);
});

gulp.task('default', ['compass', 'bower', 'js', 'watch'])