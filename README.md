<!-- START_METADATA
---
title: Vipps Login for Drupal plugin
sidebar_position: 1
description: Allow customers to log in to Drupal using the Vipps app.
pagination_next: null
pagination_prev: null
---
END_METADATA -->

# Vipps Login for Drupal

![Support and development by Frontkom ](./docs/images/frontkom.svg#gh-light-mode-only)![Support and development by Frontkom](./docs/images/frontkom_dark.svg#gh-dark-mode-only)

![null](./docs/images/vipps.png) *Only available for Vipps.*

*This plugin is built and maintained by [Frontkom](https://frontkom.com/) and hosted on [GitHub](https://github.com/vippsas/vipps-login-drupal).
For support, create an issue in the [issue queue](https://www.drupal.org/project/issues/social_auth_vipps).*

<!-- START_COMMENT -->
💥 Please use the plugin pages on [https://developer.vippsmobilepay.com](https://developer.vippsmobilepay.com/docs/plugins-ext/login-drupal/). 💥

## Table of contents

* [Introduction](#introduction)
* [Requirements](#requirements)
* [Getting started](#getting-started)
* [Installation](#installation)
* [Configuration](#configuration)
* [How it works](#how-it-works)
* [Frequently Asked Questions](#frequently-asked-questions)

## Introduction

<!-- END_COMMENT -->

This project is based on [Social API](https://www.drupal.org/project/social_api) and [Social Auth](https://www.drupal.org/project/social_auth).

The module lets you log in to Drupal using the Vipps app. It's a secure and reliable way to handle user authentication.

The module adds two things:

* An alternative URL for login: `/user/login/vipps`

* A button that can be positioned as a block or as part of the standard login form

![Login page with social auth block](https://www.drupal.org/files/social_auth_vipps_login.png)

See how it works in this video:
[![See how it works in this video](https://i.imgur.com/7OmBJjM.png)](https://player.vimeo.com/video/419856996)


## Requirements

* Drupal 8.x
* Composer
* [Social API](https://www.drupal.org/project/social_api)
* [Social Auth](https://www.drupal.org/project/social_auth)
* Working Vipps account (see below)

## Getting started

* Sign up to use [*Payment Integration*](https://vippsmobilepay.com/online/payment-integration).
* After 1-2 days, you will get an email with login details to the Merchant Portal, [portal.vippsmobilepay.com](https://portal.vippsmobilepay.com/). This is where you can retrieve the API credentials used to configure the module in Drupal.
* Proceed to [Installation](#installation) below.

### Installation

* Install dependencies
* Install the module

If you install the module using Composer, the dependencies will be added automatically:

`composer require "drupal/social_auth_vipps"`

### Configuration

* Add your Vipps project OAuth information in
*Configuration* > *User Authentication* > Vipps*.

![Social auth Vipps module configuration](https://www.drupal.org/files/social_auth_vipps_config.png)

* Place a *Social Auth Login* block in *Structure* > *Block Layout*.

![Social auth block configuration](https://www.drupal.org/files/social_auth_vipps_block.png)

* OR: Click *Show in login form*

* If you already have a *Social Auth Login* block on the site, rebuild the cache.

## How it works

The user can click on the Vipps logo in the *Social Auth Login* block. You can also add a button or link anywhere on the site that points to `/user/login/vipps`, so theming and customizing the button or link is very easy.

After Vipps has returned the user to your site, the module compares the user ID or email address provided by Vipps. If the user has previously registered using Vipps or your site already has an account with the same email address, the user is logged in. If not, a new user account is created. Also, a Vipps account can be associated with an authenticated user by matching the email address.

## Frequently Asked Questions

### How can I get help with the module?

See [Support](#support).

### Where can I use Vipps?

Vipps is only available in Norway at the moment and only users who have the Vipps app installed will be able to log in with Vipps.

## Support

Check out the [documentation pages for the module on Drupal.org](https://www.drupal.org/project/social_auth_vipps). If you still have issues,
please create an issue in the [issue queue](https://www.drupal.org/project/issues/social_auth_vipps) for the module. Before posting a support request, please check the *Recent Log* entries at `admin/reports/dblog`.
