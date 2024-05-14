# Changelog

## v8.13.2 (2024-05-14)

### What's fixed
- Add social image route for default site. 53323541 by @robdekort

## v8.13.1 (2024-05-02)

### What's fixed
- Simplify routing so they can be cached. 7108d352 by @robdekort

## v8.13.0 (2024-05-02)

### What's new
- Add support for the self hosted Matomo Tag Manager. 3e6456ff by @robdekort

## v8.12.0 (2024-05-02)

### What's improved
- Use closures for routes for better performance and multisite in Statamic v5. 359e95bb by @jesseleite and @jasonvarga

## v8.11.0 (2024-04-19)

### What's new
- Support Statamic v5. #43 by @robdekort

## v8.10.0 (2024-04-03)

### What's improved
- Strip script tags from inline scripts when using custom scripts. 65cf6102 by @robdekort

## v8.9.0 (2024-03-21)

### What's new
- The ability to list services used (per consent category) in the consent banner. 7053062c by @robdekort

## v8.3.1 (2024-03-20)

### What's fixed
- Fix broken cookie notice links in consent banner. 50e89552 by @robdekort

## v8.3.0 (2024-03-12)

### What's new
- Add a Reject All button to the Consent Banner. 46c35190 by @robdekort

## v8.2.1 (2024-03-06)

### What's fixed
- An issue when migrating to the Eloquent driver. b35d91cf by @robdekort

## v8.2.0 (2024-02-14)

### What's improved
- Filter out entries without a permalink from the sitemap. 7a7ec41f by @robdekort

## v8.1.1 (2024-02-09)

### What's fixed
- A faulty condition in the SEO snippet. 1fbe159c by @robdekort

## v8.1.0 (2024-01-26)

### What's new
- Ability to use Antlers in inline scripts behind the consent banner. b33c85cb by @robdekort

## v8.0.0 (2024-01-05)

### What's new
- The Cookie banner is now called Consent banner and fully rewritten. An update script should automatically take care of all [changes needed in Peak](https://github.com/studio1902/statamic-peak/pull/374). #40 by @robdekort and @marcorieser

## v7.5.0 (2023-12-15)

### What's new
- Support script attributes when using the cookie banner. 9981c660 and bff684d2 by @robdekort

## v7.4.3 (2023-12-15)

### What's fixed
- Fix attributes field condition. Sorry. 7eca9029 by @robdekort

## v7.4.2 (2023-12-15)

### What's improved
- Support attributes on script tags as well. 00f3f63f by @robdekort

## v7.4.1 (2023-12-14)

### What's fixed
- Use `entities` modifier for attribute values. d65ff3f1 by @robdekort

## v7.4.0 (2023-12-14)

### What's new
- The option to add attributes to an inline script. c0953d63 by @robdekort

## v7.3.2 (2023-12-08)

### What's fixed
- Prevent 500 error in Statamic v4.39.0. 327de799 by @robdekort

## v7.3.1 (2023-11-28)

### What's fixed
- Enforce use of the redirect tag. #38 by @freshface

## v7.3.0 (2023-11-22)

### What's new
- Added `og:url`` to SEO partial. #36 by @vannut

## v7.2.2 (2023-11-21)

### What's fixed
- Fixed a Cookie Banner issue where embed consent required a reload for the embeds to show. 1c9f8f2b by @robdekort

## v7.2.1 (2023-11-13)

### What's improved
- Prevent loop when both Sitemap and Social Images are disabled. 61667e30 by @robdekort

## v7.2.0 (2023-11-13)

### What's new
- Add an option to disable the Sitemap functionality. f6fca686 by @robdekort

## v7.1.0 (2023-11-09)

### What's new
- Add middle dot page title separator. 4a1310c4 by @robdekort

## v7.0.4 (2023-11-01)

### What's fixed
- Register Sitemap and Social Images routes explicitely per site. #35 by @marcorieser

## v7.0.3 (2023-09-21)

### What's improved
- Only add Cookie notice global fields if they don't exist yet. 28dd3d6e by @robdekort

## v7.0.2 (2023-09-11)

### What's improved
- Update Privacy Policy and Cookie Notice field instructions. fc2e884c by @robdekort

## v7.0.1 (2023-09-09)

### What's fixed
- Fix AddCookieNotice update script version constrainst. 1eb84bd4 by @robdekort

## v7.0 (2023-09-09)

### What's new
- Add Cookie Notice Global and use this Entry or PDF in the Cookie Banner instead of the Privacy Policy. An Update Script will automatically add this to your Globals. #32 by @robdekort

## v6.0.1 (2023-09-04)

### What's fixed
- Fix wrong loop ending. #31 by @stefankempf

## v6.0 (2023-08-22)

### What's changed
- Removed all Twitter specific meta tags and OG images. `X` will fall back to the default OG meta tags, as long as they choose to keep respecting the spec, which doesn't seem to be the case. ec83c39a by @robdekort

## v5.0 (2023-08-04)

### What's new
- Accept all / Accept selected buttons in Cookie Banner. Make sure to update your string translation files. 7c10eb82 by @robdekort

### What's improved
- Update tracker field instructions. d177e0ab by @robdekort
- Update redirect field instructions. 47560930 by @robdekort

## v4.0.1 (2023-07-15)

### What's improved
- Grammar fixes. #29 by @hybridvision

## v4.0 (2023-07-13)

### What's changed
- Remove noscript GTM tracking. #28 by @marcorieser

## v3.0 (2023-07-07)

### What's new
- Add option to add after body content in the Custom Script option for Trackers. #27 by @robdekort

## v2.6.2 (2023-07-04)

### What's improved
- Actually merge in "Optimize sitemap routes" this time. #25 by @marcorieser

## v2.6.1 (2023-07-01)

### What's fixed
- Fix to support multisite with absolute urls. #23 by @sandergo

### What's improved
- Match .env variable name with config. #24 by @marcorieser

## v2.6 (2023-06-30)

### What's new
- Adds config option for setting queue name for social images. #22 by @sandergo

## v2.5 (2023-06-29)

### What's new
- Adds support for s3 driver to store generated Twitter image. #18 by @sandergo
- Add ability to configure binary paths for social image generation. #19 by @marcorieser

## v2.4 (2023-06-28)

### What's new
- Support s3 drivers for social_images disk. #17 by @sandergo

## v2.3 (2023-06-14)

### What's improved
- Use Null Coalescence (variable fallbacks) in SEO partial. a19fce11 by @robdekort

## v2.2 (2023-06-06)

### What's new
- Adds taxonomies and collection assigned taxonomies to sitemap. #14 by @mikemartin

## v2.1.1 (2023-05-31)

### What's fixed
- Use `var` to keep external scripts in function scope to add prevent errors after cookie consent has been revoked and granted again. 6d03a93b by @robdekort

## v2.1 (2023-05-22)

### What's new
- Add the ability to set `reset_cookie_consent_class` to override the default reset link styling. 18f759a4 by @robdekort

## v2.0 (2023-05-09)

**Breaking changes**: If you upgrade an existing site make sure to apply the [changes made to Peak Core in v12](https://github.com/studio1902/statamic-peak/releases/tag/v12.0).

### What's new
- Statamic v4 support including splitting fieldsets into sections and moving the MissingAltWidget to the Tools addon. #9 by @robdekort

### What's improved
- Show `hide_by_default` (Cookie Banner) only if no trackers are being used. #b01ae61a by @robdekort

## v1.7 (2023-03-18)

### What's improved
- Use partial tag method. a992800d by @robdekort

## v1.6.1 (2023-03-05)

### What's fixed
- Use a non unique key for job overlaps. e2587193 by @robdekort

## v1.6 (2023-03-05)

### What's improved
- Improve reliability of queued OG image generation by preventing job overlap. #7 by @robdekort

## v1.5.1 (2023-02-21)

### What's fixed
- Restore conditional field logic regarding page titles. e8d3f157 by @robdekort

## v1.5 (2023-02-21)

### What's new
- Add an option to fully replace collection titles. #6 by @robdekort

## v1.4 (2023-02-21)

### What's improved
- Use Null-safe operator in Social Image route guard. #5 by @marcorieser

## v1.3 (2023-02-17)

### What's improved
- Improve global labels for social image generation. #4 by @klickreflex

## v1.2.1 (2023-02-09)

### What's fixed
- Fix ErrorPage handler creating endless loop. #3 by @marcorieser

## v1.2 (2023-02-09)

### What's new
- Changes for addonification. #2 by @marcorieser

## v1.1 (2023-02-07)

### What's new
- Add ability to publish fieldsets. #1 by @marcorieser

## v1.0 (2023-02-07)

- Initial release.
