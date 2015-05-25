# yii2-atlas

  Extension for the Yii2 framework that submits Yii errors to the Atlas API.

## Requirements

  This extension requires PHP cURL support.

## Installation
  The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

  Either run

    php composer.phar require --prefer-dist boundstate/yii2-atlas "*"

  or add

    "boundstate/yii2-atlas": "*"

  to the require section of your `composer.json` file.

## Usage

  Setup the components in your config:

    'atlas' => [
        'class' => 'boundstate\atlas\Atlas',
        'baseUrl' => 'https://atlas.boundstatesoftware.com',
        'appId' => 'your-app-id',
    ],

    'errorHandler' => [
        'class' => 'boundstate\atlas\ErrorHandler',
    ],