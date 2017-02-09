var gulp        = require('gulp'),
    less        = require('gulp-less'),
    minifyCss   = require('gulp-minify-css'),
    livereload  = require('gulp-livereload'),
    browserSync = require('browser-sync').create(),
    reload      = browserSync.reload;


// 压缩bjy-开头的css文件
gulp.task('minify-css', function(){
    gulp.src('tpl/**/*.less')
        .pipe(less())
        .pipe(minifyCss())
        .pipe(gulp.dest('tpl'))
})
// 为了避免冲突bjy-的压缩；其他的不压缩
// gulp.task('othercss', function(){
//     gulp.src(['tpl/**/*.less', '!tpl/**/bjy-*.less'])
//         .pipe(less())
//         .pipe(gulp.dest('tpl'))
// })

// 编译全部less但不压缩
gulp.task('css', function(){
    gulp.src('tpl/**/*.less')
        .pipe(less())
        .pipe(gulp.dest('tpl'))
})

// 自动刷新
gulp.task('server', function() {
    browserSync.init({
        proxy: "my.shishiping.com", // 指定代理url
        notify: false, // 刷新不弹出提示
        open: false, // 不自动打开浏览器
    });
    // 监听less文件编译
    gulp.watch('tpl/**/*.less', ['minify-css']);   
    // 监听html文件变化后刷新页面
    gulp.watch("tpl/**/*.html").on("change", reload);
    // 监听css文件变化后刷新页面
    gulp.watch("tpl/**/*.css").on("change", reload);
});

// 监听事件
gulp.task('default', ['server'])