let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build')
    .setPublicPath('/build')
    .addEntry('app', './assets/js/app.js')
    .cleanupOutputBeforeBuild()
    .enableSassLoader()
    .addEntry('style', './assets/scss/main.scss')
    .addEntry('profile', './assets/scss/profile.scss')
    .addEntry('home', './assets/scss/home.scss')
    .addEntry('accueil', './assets/images/accueil.jpeg')
    .addEntry('event', './assets/scss/event.scss')
    .enableBuildNotifications();

module.exports = Encore.getWebpackConfig();