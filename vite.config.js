
// import { defineConfig } from 'vite';
const vite = require('vite');
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy'

export default vite.defineConfig({
    build: {
        manifest: true,
        // assetsDir: 'js',
        rtl: true,
        outDir: 'public/build/',
        cssCodeSplit: true,
        rollupOptions: {
            output: {
              assetFileNames: (css) => {
                if(css.name.split('.').pop() == 'css') {
                    return 'css/' + `[name]` + '.min.' + 'css';
                } else {
                    return 'icons/' + css.name;
                }
            },
                entryFileNames: 'js/' + `[name]` + `.js`,
            },
        },
      },
    plugins: [
        laravel(
            {
                input: [
                    'resources/scss/app.scss',
                    'resources/scss/bootstrap.scss',
                    'resources/scss/icons.scss',
                    'resources/scss/custom.scss',
                ],
                refresh: true,                
            }
        ),
         viteStaticCopy({
            targets: [
                {
                    src: 'resources/fonts',
                    dest: ''
                },
                {
                    src: 'resources/images',
                    dest: ''
                },
                {
                    src: 'resources/json',
                    dest: ''
                },
                {
                    src: 'resources/js',
                    dest: ''
                },
                {
                    src: 'resources/lang',
                    dest: ''
                },

                {
                    src: [
                        'node_modules/bootstrap/dist/css/bootstrap.min.css',
                        'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
                    ],
                    dest: 'libs/bootstrap'
                },

                {
                    src: ['./node_modules/simplebar/dist/simplebar.js'],
                    dest: 'libs/simplebar',
                    rename: 'simplebar.min.js',
                },

                {
                    src: ['./node_modules/isotope-layout/dist/isotope.pkgd.min.js'],
                    dest: 'libs/isotope-layout',
                },

                {
                    src: ['./node_modules/masonry-layout/dist/masonry.pkgd.min.js'],
                    dest: 'libs/masonry-layout',
                },

                {
                    src: ['./node_modules/choices.js/public/assets/scripts/choices.min.js'],
                    dest: 'libs/choices.js',
                },

                {
                    src: ["./node_modules/swiper/swiper-bundle.min.js", "./node_modules/swiper/swiper-bundle.min.css"],
                    dest: 'libs/swiper'
                },

                {
                    src: ["./node_modules/nouislider/dist/nouislider.min.css", "./node_modules/nouislider/dist/nouislider.min.js"],
                    dest: 'libs/nouislider'
                },

                {
                    src: ["./node_modules/wnumb/wNumb.min.js"],
                    dest: 'libs/wnumb'
                },

                {
                    src: ["./node_modules/jsvectormap/dist/css/jsvectormap.min.css", "./node_modules/jsvectormap/dist/js/jsvectormap.min.js", "./node_modules/jsvectormap/dist/maps/world-merc.js", "./node_modules/jsvectormap/dist/maps/world-merc.js", "./node_modules/jsvectormap/dist/maps/us-merc-en.js", "./node_modules/jsvectormap/dist/maps/canada.js", "./node_modules/jsvectormap/dist/maps/russia.js",
                    "./node_modules/jsvectormap/dist/maps/spain.js"],
                    dest: 'libs/jsvectormap'
                },

                {
                    src: ['./node_modules/gridjs/dist/theme/mermaid.min.css', './node_modules/gridjs/dist/gridjs.umd.js'],
                    dest: 'libs/gridjs'
                },

                {
                    src: ['./node_modules/flatpickr/dist/flatpickr.min.css', './node_modules/flatpickr/dist/flatpickr.min.js'],
                    dest: 'libs/flatpickr'
                },
            ]
         }),
    ],
});