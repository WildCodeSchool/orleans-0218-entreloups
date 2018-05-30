let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build')
    .setPublicPath('/build')
    .addEntry('app', './assets/js/app.js')
    .addEntry('datepicker', './assets/js/datepicker.js')
    .cleanupOutputBeforeBuild()
    .enableSassLoader()
    .addStyleEntry('style', './assets/scss/main.scss')
    .addStyleEntry('home', './assets/scss/home.scss')
    .addStyleEntry('profile', './assets/scss/profile.scss')
    .addEntry('accueil', './assets/images/accueil.jpeg')
    .addStyleEntry('event', './assets/scss/event.scss')
    .enableBuildNotifications()
    .autoProvidejQuery();

module.exports = Encore.getWebpackConfig();