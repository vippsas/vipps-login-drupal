###Contents of this file
 * [_Introduction_](#introduction)
 * [ Requirements ](#requirements)
 * [_Getting started_](#getting-started)
 * [_Installation_](#installation)
 * [_Configuration_](#configuration)
 * [_How it works_](#how-it-works)
 * [_Support requests_](#support-requests)

## Introduction
Social Auth Vipps is a Vipps authentication integration for
Drupal. It is based on the Social Auth and Social API projects

It adds to the site:
* A new url: /user/login/vipps.
* A settings form at /admin/config/social-api/social-auth/vipps.
* A Vipps logo in the Social Auth Login block.


## Requirements
This module requires the following modules:
 * Social Auth (https://drupal.org/project/social_auth)
 * Social API (https://drupal.org/project/social_api)
 * Working Vipps account (see below)

## Getting started
* Sign up to use (Vipps på Nett)
* After 1-2 days you will get an email with login details to Vipps Developer Portal. This is where you can retrieve the API credentials used to configure the module in Drupal.
* Proceed to "Installation" below

## Installation
 * Run composer to install the dependencies.
   composer require "drupal/social_auth_vipps:^2.0"
 * Install the dependencies: Social API and Social Auth.
 * Install as you would normally install a contributed Drupal module. See:
   https://drupal.org/documentation/install/modules-themes/modules-8
   for further information.
 * A more comprehensive installation instruction for Drupal 8 can be found at
   https://www.drupal.org/docs/8/modules/social-api/social-api-2x/social-auth-2x/installing-social-auth-2x


## Configuration
 * Add your Vipps project OAuth information in
   Configuration » User Authentication » Vipps.
 * Place a Social Auth Login block in Structure » Block Layout.
 * If you already have a Social Auth Login block in the site, rebuild the cache.


## How it works
The user can click on the Vipps logo in the Social Auth Login block.
You can also add a button or link anywhere on the site that points
to /user/login/vipps, so theming and customizing the button or link
is very flexible.

After Vipps has returned the user to your site, the module compares the
user id or email address provided by Vipps. If the user has previously
registered using Vipps or your site already has an account with the same
email address, the user is logged in. If not, a new user account is created.
Also, a Vipps account can be associated with an authenticated user.


## Support requests
* Before posting a support request, carefully read the installation
  instructions provided in module documentation page.
* Before posting a support request, check the Recent Log entries at
  admin/reports/dblog
* Once you have done this, you can post a support request at module issue
  queue: https://www.drupal.org/project/issues/social_auth_vipps
* When posting a support request, please inform if you were able to see any
  errors in the Recent Log entries.
