var gulp = require('gulp'),
    less = require('gulp-less'),
    csso = require('gulp-csso'),
    modifyCssUrls = require('gulp-modify-css-urls'),
    imagemin = require('gulp-imagemin'),
    uglify = require('gulp-uglify')
;

var
    buildTime = + new Date(),
    srcPath = 'assets/',
    buildPath = 'assets/build/'
;

gulp.task('css', function(){
    return gulp.src(srcPath + 'css/**/*.less')
        .pipe(less())
        .pipe(modifyCssUrls({
            modify: function (url, filePath) {
                /*if (url.includes('../img/')) {
                    url = '../' + url;
                }*/
                if (buildTime) {
                    if (url.includes('?')) {
                        url += '&t=' + buildTime;
                    } else {
                        url += '?t=' + buildTime;
                    }
                }
                return url;
            }
        }))
        .pipe(csso())
        .pipe(gulp.dest(buildPath + 'css'))
});

gulp.task('js', function(){
    return gulp.src(srcPath + 'js/**/*.js')
        .pipe(uglify())
        .pipe(gulp.dest(buildPath + 'js'))
});

gulp.task('fonts', function() {
    return gulp.src(srcPath + 'fonts/**/*.*')
        .pipe(gulp.dest(buildPath + 'fonts'))
});

gulp.task('image', function () {
    return gulp.src(srcPath + 'img/**/*.*')
        .pipe(imagemin())
        .pipe(gulp.dest(buildPath + 'img'));
});

gulp.task('adminpro-css', function () {
    return gulp.src('admin-pro/minimal/css/**/*.css')
        .pipe(csso())
        .pipe(gulp.dest('admin-pro/build/minimal/css'))
});

gulp.task('adminpro-js', function(){
    return gulp.src('admin-pro/minimal/js/**/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('admin-pro/build/minimal/js'))
});

gulp.task('adminpro-images', function () {
    return gulp.src('admin-pro/assets/images/**/*.*')
        .pipe(imagemin())
        .pipe(gulp.dest('admin-pro/build/assets/images'));
});


gulp.task('watch', ['build'], function() {
    gulp.watch(srcPath + 'js/**/*.js', ['js']);
    gulp.watch(srcPath + 'css/**/*.less', ['css']);
    gulp.watch(srcPath + 'img/**/*.*', ['image']);
});

gulp.task('build', ['css', 'js', 'fonts', 'image']);
gulp.task('fast', ['css', 'js']);
gulp.task('images', ['image']);
gulp.task('adminpro', ['adminpro-css', 'adminpro-js', 'adminpro-images']);
gulp.task('default', ['watch']);