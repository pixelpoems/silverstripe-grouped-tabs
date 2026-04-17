// Do not change the following lines if you do not know what you are doing - the project config is placed here: ./vite.project.js

import {defineConfig} from 'vite'

// https://vite.dev/config/
export default defineConfig(async ({command, mode, isSsrBuild, isPreview}) => {
    return {
        base: '', // Important that the fonts are loaded correctly
        build: { // https://vite.dev/config/build-options.html
            commonjsOptions: {
                transformMixedEsModules: true
            },
            outDir: './client/dist',
            emptyOutDir: true,
            assetsDir: 'assets', // Default: assets
            manifest: true,
            sourcemap: true,
            rollupOptions: {
                input: {
                    'grouped-tabs.css': './client/src/grouped-tabs.scss',
                    'grouped-tabs': './client/src/grouped-tabs.js',
                },
                output: {
                    assetFileNames: '[name].[ext]',
                    entryFileNames: '[name].js'
                }
            }
        }
    };
});
