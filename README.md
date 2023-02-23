# Web Fonts API tester plugin using Jetpack's Google Fonts composer package

This is a tester plugin for the Web Fonts API. It uses the [Jetpack Google Fonts Provider composer package](https://packagist.org/packages/automattic/jetpack-google-fonts-provider).

## Modified by @ironprogrammer

In this fork, fonts that are already registered in TT3 have been removed. This change is to prevent re-registration of those fonts, an issue that should be addressed separately.

> 🚨 **If there were testing instructions in the ticket that led you here, those should supersede what is provided below.**

## Modified by MReishus

This has been modified to match Jetpack's current implementation of the Google
Fonts API as of 2023-02-21.

See: https://github.com/Automattic/jetpack/blob/27e5706af62189442b41a35fb8c75bfdc259b3d1/projects/plugins/jetpack/modules/google-fonts.php#L21

Original Copy was from: https://gist.github.com/hellofromtonya/1bbbc9a5354a905278080a9f022c2f60#file-webfonts-php-L102

### Purpose

- This is only to illustrate a bug. Please don't use for any other purpose.

## How to install

1. In your local dev environment, create a new folder in `wp-content/plugins/` called `webfonts`.
2. In a command line tool (such as Terminal), type: `composer install`.
3. Then activate the plugin in your test site's admin area.

## How to test

1. Open the Site Editor
2. Open the Global Styles UI
3. Open Typography
4. Open `Text`
5. Select a Google Font
   * Expected behavior: The text should change to that font.
6. Then go to `Heaings`
7. Select a Google Font
    * Expected behavior: The headings should change to that font.
8. Save the global styles.
9. Go to the front-end. Then visually check that the text and headings look like for those fonts.
10. Check the error log to verify deprecation notices are present.

## What should the fonts visually look like?

This plugin has the following fonts. You can visually see how the font should look by clicking to go to Google Fonts website.

* Arvo: [Visually see it](https://fonts.google.com/specimen/Arvo?query=Arvo)
* Lato: [Visually see it](https://fonts.google.com/specimen/Lato?query=Lato)
* Merriweather: [Visually see it](https://fonts.google.com/specimen/Merriweather?query=Merriweather)
* Playfair Display: [Visually see it](https://fonts.google.com/specimen/Playfair+Display?query=Playfair)
* Roboto: [Visually see it](https://fonts.google.com/specimen/Merriweather?query=Roboto)
