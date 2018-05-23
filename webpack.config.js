let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/web')
    .addEntry('app', './assets/js/app.js')
    .cleanupOutputBeforeBuild()
    .enableSassLoader()
    .addEntry('style', './assets/scss/main.scss')
    .addEntry('home', './assets/scss/home.scss')
    .enableBuildNotifications();

module.exports = Encore.getWebpackConfig();