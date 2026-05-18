# Plan: Minify Build Result via Vite JS Entries

## Current Situation

- Vite config (`vite.config.js`) only processes SCSS files as entries. JS files are **copied as-is** via `vite-plugin-static-copy` — no minification, no tree-shaking.
- Blade templates reference JS via `URL::asset('build/js/...')` with direct `<script>` tags (not `@vite()` directive).
- Current output structure: `public/build/js/{subdir}/{filename}.js`
- CSS is already minified via Vite's SCSS pipeline.

## Problem

Adding JS files as Vite entries will produce hashed filenames (e.g., `assets/menu.init-4f2a1b.js`), which breaks all existing `<script src="URL::asset('build/js/...')">` references in Blade templates.

## Strategy: Add JS entries + preserve output paths + update Blade references

Since Vite's default output uses content-hashed filenames and a flat structure, we need to configure `rollupOptions.output` to preserve the existing path convention, then update Blade templates to use the Vite manifest for asset resolution.

---

## Step 1: Add JS files as Vite entries in `vite.config.js`

Add all JS entry points to the `laravel()` plugin's `input` array:

```js
input: [
    // Existing SCSS entries
    'resources/scss/app.scss',
    'resources/scss/bootstrap.scss',
    'resources/scss/icons.scss',
    'resources/scss/custom.scss',
    'resources/scss/custom-catalogue.scss',

    // JS entries - root
    'resources/js/app.js',
    'resources/js/layout.js',
    'resources/js/plugins.js',

    // JS entries - frontend
    'resources/js/frontend/address.init.js',
    'resources/js/frontend/catalogue.init.js',
    'resources/js/frontend/category.init.js',
    'resources/js/frontend/landing-index.init.js',
    'resources/js/frontend/lagramma-cart.init.js',
    'resources/js/frontend/lagramma-checkout.init.js',
    'resources/js/frontend/menu.init.js',
    'resources/js/frontend/modern-fashion.init.js',
    'resources/js/frontend/product-detail.init.js',
    'resources/js/frontend/product-details.init.js',
    'resources/js/frontend/product-grid.init.js',
    'resources/js/frontend/product-list-table.init.js',
    'resources/js/frontend/product-list.init.js',
    'resources/js/frontend/store-locator.init.js',
    'resources/js/frontend/trend-fashion.init.js',
    'resources/js/frontend/watch-demo.init.js',

    // JS entries - pages
    'resources/js/pages/coming-soon.init.js',
    'resources/js/pages/form-wizard.init.js',
    'resources/js/pages/password-addon.init.js',
    'resources/js/pages/password-match.init.js',
    'resources/js/pages/passowrd-create.init.js',
    'resources/js/pages/two-step-verification.init.js',
]
```

**Note:** Only JS files actually referenced in Blade templates need to be added. The unused backend/pages JS can stay as static copies or be added later.

## Step 2: Remove `resources/js` from `viteStaticCopy` targets

Remove this block from the static copy config (since these JS files are now Vite entries):

```js
// REMOVE this target:
{
    src: 'resources/js',
    dest: ''
},
```

Keep the `resources/js/backend/` and `resources/js/pages/` (unused ones) as static copies if needed, or remove them entirely if they're not used in the frontend app.

## Step 3: Update `rollupOptions.output.entryFileNames` to preserve paths

Update the entry file naming to keep the subfolder structure:

```js
rollupOptions: {
    output: {
        assetFileNames: (assetInfo) => {
            if (assetInfo.name && assetInfo.name.split('.').pop() === 'css') {
                return 'css/' + `[name]` + '.min.css';
            }
            return 'icons/' + assetInfo.name;
        },
        entryFileNames: (chunkInfo) => {
            // Preserve subfolder structure: frontend/xxx.js, pages/xxx.js, etc.
            const srcPath = chunkInfo.facadeModuleId
                ? chunkInfo.facadeModuleId.replace(/\\/g, '/')
                : '';
            const match = srcPath.match(/resources\/js\/(.*)\.js/);
            const subPath = match ? match[1] : chunkInfo.name;
            return 'js/' + subPath + '.js';
        },
        // Preserve module structure so entryFileNames works per-entry
        manualChunks: undefined,
    },
},
```

This produces output like:
- `public/build/js/app.js`
- `public/build/js/frontend/menu.init.js`
- `public/build/js/pages/coming-soon.init.js`

Which matches the existing `URL::asset('build/js/...')` paths — **no Blade changes needed**.

## Step 4: Add `build.minify` option

Vite already minifies by default in production mode (`vite build`). To verify/force it:

```js
build: {
    minify: true, // 'esbuild' by default, already enabled for `vite build`
    // Optional: switch to terser for smaller output
    // minify: 'terser',
}
```

## Step 5: Build and verify

```bash
npm run build
```

Verify:
- `public/build/js/` contains minified JS files with the correct folder structure
- `public/build/manifest.json` includes the JS entries
- Load a page in the browser and confirm all JS still works

---

## Files to Modify

| File | Change |
|---|---|
| `vite.config.js` | Add JS entries, update `entryFileNames`, remove `resources/js` from static copy |

## Files NOT Modified

- All Blade templates remain unchanged (output paths stay the same)
- `package.json` — no new dependencies needed

## Risks / Considerations

1. **`app.js` (86KB)** is a large monolithic file. When processed by Vite, it will be minified but also analyzed for imports. If it uses CommonJS patterns or browser globals, it should still work since Vite handles IIFE/self-executing functions fine.
2. **Global variables**: Some JS files may rely on globals set by other scripts (e.g., `app.js` defines layout behavior). The load order is determined by `<script>` tag order in Blade, which won't change.
3. **Unused JS files** in `resources/js/backend/` and `resources/js/pages/` (apexcharts, leaflet, etc.) are not referenced in Blade templates and can be removed from the static copy to reduce build output size.
