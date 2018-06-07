let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build')
    .setPublicPath('/build')
    .addEntry('app', './assets/js/app.js')
    .addEntry('bootstrap-tagsinput', './assets/js/tagsinput/bootstrap-tagsinput.js')
    .addEntry('typeahead.bundle', './assets/js/tagsinput/typeahead.bundle.js')
    .addEntry('datepicker', './assets/js/datepicker.js')
    .cleanupOutputBeforeBuild()
    .enableSassLoader()
    .addStyleEntry('style', './assets/scss/main.scss')
    .addStyleEntry('bootstrap-tagsinputCSS', './assets/css/bootstrap-tagsinput.css')
    .addStyleEntry('listTag', './assets/scss/listTag.scss')
    .addStyleEntry('home', './assets/scss/home.scss')
    .addEntry('accueil', './assets/images/accueil.jpeg')
    .addStyleEntry('event', './assets/scss/event.scss')
    .enableBuildNotifications()
    .autoProvidejQuery();

module.exports = Encore.getWebpackConfig();