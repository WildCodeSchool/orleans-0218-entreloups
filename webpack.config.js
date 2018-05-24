let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build')
    .setPublicPath('/build')
    .addEntry('app', './assets/js/app.js')
    .cleanupOutputBeforeBuild()
    .enableSassLoader()
    .addStyleEntry('style', './assets/scss/main.scss')
    .enableBuildNotifications()
;

module.exports = Encore.getWebpackConfig();