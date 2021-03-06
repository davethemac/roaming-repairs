// Karma configuration
// Generated on Sat Jun 03 2017 21:22:11 GMT+0100 (BST)

module.exports = function(config) {
  config.set({

    // base path that will be used to resolve all patterns (eg. files, exclude)
    basePath: '',


    // frameworks to use
    // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
    frameworks: ['qunit'],

plugins: [
      require('karma-qunit'),
      require('karma-chrome-launcher'),
      require('karma-firefox-launcher'),
      require('karma-coverage')
    ],
    // list of files / patterns to load in the browser
    files: [
      'web/lib/jquery-2.2.4.min.js',
      'web/lib/jquery.validate.min.js',
      'web/lib/handlebars.min.js',
      'web/js/*.js',
      'web/js/*/*.js',
      'test/qunit/*.js'
    ],


    // list of files to exclude
    exclude: [
    ],


    // preprocess matching files before serving them to the browser
    // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
    preprocessors: {
        'web/js/WebStorage/WebStorageService.js': ['coverage']
    },


    // test results reporter to use
    // possible values: 'dots', 'progress'
    // available reporters: https://npmjs.org/browse/keyword/karma-reporter
    reporters: ['progress', 'coverage'],

    // optionally, configure the reporter 
    coverageReporter: {
      type : 'html',
      dir : 'coverage/',
      subdir: function(browser) {
          // normalization process to keep a consistent browser name across different OS
          return browser.toLowerCase().split(/[ /-]/)[0];
      }
    },
    
    // web server port
    port: 9876,


    // enable / disable colors in the output (reporters and logs)
    colors: true,


    // level of logging
    // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
    logLevel: config.LOG_INFO,


    // enable / disable watching file and executing tests whenever any file changes
    autoWatch: true,


    // start these browsers
    // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
    browsers: ['Chrome', 'Firefox'],


    // Continuous Integration mode
    // if true, Karma captures browsers, runs the tests and exits
    singleRun: false,

    // Concurrency level
    // how many browser should be started simultaneous
    concurrency: Infinity
  });
};
