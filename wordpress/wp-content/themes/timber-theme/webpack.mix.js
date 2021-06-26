const mix = require('laravel-mix');
const BundleAnalyzerPlugin =
  require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
require('laravel-mix-compress');

mix
  .setPublicPath('./static/dist/')
  .setResourceRoot('/wp-content/themes/timber-theme/static/dist/')
  .webpackConfig({
    output: { publicPath: '/wp-content/themes/timber-theme/static/dist/' },
    optimization: {
      splitChunks: { chunks: 'async' },
    },
  });

mix.browserSync({
  proxy: 'alumash.lndo.site',
  open: false,
  files: [
    'static/styles/**/*.(css|scss)',
    'static/scripts/**/*.{js|ts}',
    '**/*.php',
    'views/**/*.twig',
  ],
});

mix.sass('static/styles/index.scss', './styles/');
mix.ts('static/scripts/index.ts', './scripts/');
mix.sourceMaps();
mix.version();
mix.compress();
mix.disableSuccessNotifications();
mix.options({ processCssUrls: false });

if (mix.inProduction()) {
  mix.webpackConfig({
    plugins: [new BundleAnalyzerPlugin()],
  });
}
