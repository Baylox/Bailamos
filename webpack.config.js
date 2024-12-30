const Encore = require('@symfony/webpack-encore');

// Configure l'environnement d'exécution
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // Répertoire des assets compilés
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    // Points d'entrée
    .addEntry('app', './assets/app.js')
    .addStyleEntry('admin', './assets/styles/admin.scss')
    
    // Divise les fichiers pour optimiser le chargement
    .splitEntryChunks()
    .enableSingleRuntimeChunk()

    // Nettoyage et notifications
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()

    // Optimisations en fonction de l'environnement (Pour la prod actuellement)
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    // Babel (modernisation du JS)
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // SCSS avec options conditionnelles
    .enableSassLoader((options) => {
        options.sassOptions = {
            outputStyle: Encore.isProduction() ? 'compressed' : 'expanded',
        };
    }, {
        resolveUrlLoader: true,
    })

    // Gestion des fichiers statiques (images)
    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[ext]',
    })

    // Activation de possibles fonctionnalités supplémentaires pour la suite du projet
    //.enableReactPreset()
    //.enableTypeScriptLoader()
;

module.exports = Encore.getWebpackConfig();
