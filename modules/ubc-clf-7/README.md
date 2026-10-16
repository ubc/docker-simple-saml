# `ubc-clf-7`: the UBC Common Look and Feel for this test IdP

A SimpleSAMLphp 2.x theme module that makes the IdP's sign-in pages look like UBC's Common
Look and Feel (CLF 7), so that someone integrating CWL into an application sees roughly
what the real sign-in will look like. `config/simplesamlphp/config.php` turns it on with
`'theme.use' => 'ubc-clf-7:ubc-clf-7'`, and `docker-compose.yml` bind-mounts this
directory, so a change here needs no image rebuild.

**It is not CWL, and every page it renders says so** in a red band above the UBC header
(`#not-cwl-band` in `themes/ubc-clf-7/core/_layout.twig`).

## What it themes

Only the templates under `themes/ubc-clf-7/core/` are themed. Every other SimpleSAMLphp
page (errors, logout, the admin pages) uses SimpleSAMLphp's own look.

| Template | Page |
|---|---|
| `_layout.twig` | The shared layout: the warning band, UBC header and footer, `lang`, a viewport meta tag, and a `<title>` built from each page's `pagetitle` |
| `loginuserpass.twig` | The sign-in form. A failed sign-in shows SimpleSAMLphp's own error title and description in an alert box (`role="alert"`), and the fields carry `autocomplete="username"` / `"current-password"` |
| `welcome.twig` | `/simplesaml/` redirects here: what this service is, and how to switch test account |

Stylesheets are linked with SimpleSAMLphp's `asset('clf.css', 'ubc-clf-7')` helper, which
builds the URL from SimpleSAMLphp's own base path. The path is relative to
`public/assets/`, because `asset()` adds the `assets/` segment itself: writing
`asset('assets/clf.css', …)` yields `…/assets/assets/clf.css`, a 404, and an unstyled page.

`public/assets/clf.css` is vendored UBC CLF 7 (Bootstrap 2.3.2), kept byte-identical to its
source so it can be re-synced with a plain copy. This theme's own styles go in
`public/assets/style.css`.

## Files `clf.css` needs beside it

`clf.css` refers to a font and three images by relative URL (`../font/…`, `../img/…`).
They are committed here, so the theme is complete and works with the network off. They
were downloaded from `https://cdn.ubc.ca/clf/7.0.5/` (CLF 7.0.5):

| File (under `public/`) | Size | SHA-256 |
|---|---|---|
| `font/font-v4/fontawesome-webfont-ubc-v4.eot` | 198528 bytes | `2973f7461d0b03c6981a1e39c6a41847e04ce3474b7325d1e7eea31ce9b75bb0` |
| `font/font-v4/fontawesome-webfont-ubc-v4.ttf` | 198428 bytes | `d39bef85a045ab4e5010a14c68522c0e5415fdf67b766d96a72db4791f29d7ef` |
| `font/font-v4/fontawesome-webfont-ubc-v4.woff` | 51704 bytes | `b2a89d8840890218d665cc947a655cc862bc7c702184ccf6ec07a52bfe728c24` |
| `img/glyphicons-halflings.png` | 12799 bytes | `d99e3fa32c641032f08149914b28c2dc6acf2ec62f70987f2259eabbfa7fc0de` |
| `img/glyphicons-halflings-white.png` | 8777 bytes | `f0e0d95a9c8abcdfabf46348e2d4285829bb0491f5f6af0e05af52bffb6324c4` |
| `img/ubc7-clf-sprite-white.png` | 18003 bytes | `9720f353cde3e96e77798ae42bf70606a51e4cb30f055a829c85759c1ad0f8c2` |

`file` identifies the three fonts as EOT, TrueType and WOFF, and the three images as PNGs
(469×159, 469×159 and 1500×600), so none of them is a saved error page.

To check them: `cd modules/ubc-clf-7/public && shasum -a 256 font/font-v4/* img/*`.

## Licences

- **FontAwesome webfont** (the `fontawesome-webfont-ubc-v4.*` files, FontAwesome 3.2.0 as
  UBC's CLF ships it): SIL Open Font License 1.1, as the font's own `name` table states.
- **`clf.css`**: Bootstrap 2.3.2, Apache License 2.0, per its banner comment.
- **Glyphicons Halflings** (`img/glyphicons-halflings*.png`): the icon sprites Bootstrap
  2.3.2 distributes by arrangement with their creator, Glyphicons (glyphicons.com).
- **The CLF imagery** (`ubc7-clf-sprite-white*.png`) belongs to UBC.
