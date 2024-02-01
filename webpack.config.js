const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

let jsEntry = {
    main: "app.js",

	recipe_index_js: "recipe/index/index.js",
	recipe_new: "recipe/new/index.js",
	recipe_single_js: "recipe/single/index.js"
}

let scssEntry = {
    header: "header/header.scss",
	common: "common/common.scss",

	home: "home/index.scss",

	recipes_index: "recipes/index/index.scss",
	recipe_single_css: "recipes/single/single.scss",
	recipe_new_css: "recipes/new/index.scss",

	profile_css: "user/profile/index.scss",
	profile_edit_css: "user/profile/edit.scss",
	profile_reset_pwd_css: "user/profile/pwd-reset.scss",

	register_css: "user/register/index.scss",
	login_css: "user/login/index.scss",
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')
    .enableSassLoader()

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a new-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    //.enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push('@babel/a-babel-plugin');
    // })

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
;

for (const [name, path] of Object.entries(jsEntry))
{
    Encore.addEntry(name, "./assets/js/" + path);
}

for (const [name, path] of Object.entries(scssEntry))
{
    Encore.addEntry(name, "./assets/scss/" + path);
}


module.exports = Encore.getWebpackConfig();
