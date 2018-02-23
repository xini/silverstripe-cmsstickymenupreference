# SilverStripe CMS sticky menu preference

[![Version](http://img.shields.io/packagist/v/innoweb/silverstripe-cmsstickymenupreference.svg?style=flat-square)](https://packagist.org/packages/innoweb/silverstripe-cmsstickymenupreference)
[![License](http://img.shields.io/packagist/l/innoweb/silverstripe-cmsstickymenupreference.svg?style=flat-square)](license.md)

## Overview

Adds the ability for users to control the default CMS sticky menu setting for their login.

Based on the ideas from Webbuilders Group's [CMS Preview Preference module](https://github.com/webbuilders-group/silverstripe-cmspreviewpreference).

## Requirements

* SilverStripe CMS 4.x

Note: this version is compatible with SilverStripe 4. For SilverStripe 3, please see the [1.0 release line](https://github.com/xini/silverstripe-cmsstickymenupreference/tree/1.0).

## Installation

Install the module using composer:
```
composer require innoweb/silverstripe-cmsstickymenupreference dev-master
```
or download or git clone the module into a ‘cmsstickymenupreference’ directory in your webroot.

Then run dev/build.

## Configuration

The default menu mode is set to "default", you can change this in your config by setting the UserMenuPreference.DefaultMode setting to one of the following: "open", "closed" or "default".

```yml
Innoweb\CMSStickyMenu\Model\UserMenuPreference:
  DefaultMode: 'open'
```

## Usage

When managing a user or a user views their profile in the CMS they will see the ability to toggle which menu mode is their default menu mode, after changing this the user will be asked to reload the cms to update the setting.

## License

BSD 3-Clause License, see [License](license.md)
