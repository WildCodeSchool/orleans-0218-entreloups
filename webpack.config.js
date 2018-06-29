let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSassLoader()
    .addEntry('datepicker', './assets/js/datepicker.js')
    .addEntry('searchCity', './assets/js/searchCity.js')
    .addEntry('toggles', './assets/js/toggles.js')
    .addStyleEntry('style', './assets/scss/main.scss')
    .addStyleEntry('bootstrap-tagsinput', './assets/css/tagsinput.css')
    .addEntry('app', './assets/js/app.js')
    .addStyleEntry('home', './assets/scss/home.scss')
    .addEntry('accueil', './assets/images/accueil.jpeg')
    .addStyleEntry('event', './assets/scss/event.scss')
    .addStyleEntry('edition', './assets/scss/edition.scss')
    .addStyleEntry('toggleStyle', './assets/scss/toggleStyle.scss')
    .enableBuildNotifications()
    .autoProvidejQuery();


module.exports = Encore.getWebpackConfig();