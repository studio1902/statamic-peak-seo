# Changelog

## v2.6.1 (2023-07-01)

### What's fixed
- Fix to support multisite with absolute urls. #23 by @sandergo

### What's improved
- Match .env variable name with config. #24 by @marcorieser
- Optimize sitemap routes #25 by @marcorieser

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
