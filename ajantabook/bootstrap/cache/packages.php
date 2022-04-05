<?php

return [
  'anandsiddharth/laravel-paytm-wallet' => [
    'providers' => [
      0 => 'Anand\\LaravelPaytmWallet\\PaytmWalletServiceProvider',
    ],
    'aliases' => [
      'PaytmWallet' => 'Anand\\LaravelPaytmWallet\\Facades\\PaytmWallet',
    ],
  ],
  'arcanedev/no-captcha' => [
    'providers' => [
      0 => 'Arcanedev\\NoCaptcha\\NoCaptchaServiceProvider',
    ],
  ],
  'barryvdh/laravel-debugbar' => [
    'providers' => [
      0 => 'Barryvdh\\Debugbar\\ServiceProvider',
    ],
    'aliases' => [
      'Debugbar' => 'Barryvdh\\Debugbar\\Facades\\Debugbar',
    ],
  ],
  'barryvdh/laravel-dompdf' => [
    'providers' => [
      0 => 'Barryvdh\\DomPDF\\ServiceProvider',
    ],
    'aliases' => [
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
    ],
  ],
  'berkayk/onesignal-laravel' => [
    'providers' => [
      0 => 'Berkayk\\OneSignal\\OneSignalServiceProvider',
    ],
    'aliases' => [
      'OneSignal' => 'Berkayk\\OneSignal\\OneSignalFacade',
    ],
  ],
  'beyondcode/laravel-dump-server' => [
    'providers' => [
      0 => 'BeyondCode\\DumpServer\\DumpServerServiceProvider',
    ],
  ],
  'cartalyst/stripe-laravel' => [
    'providers' => [
      0 => 'Cartalyst\\Stripe\\Laravel\\StripeServiceProvider',
    ],
    'aliases' => [
      'Stripe' => 'Cartalyst\\Stripe\\Laravel\\Facades\\Stripe',
    ],
  ],
  'consoletvs/charts' => [
    'providers' => [
      0 => 'ConsoleTVs\\Charts\\ChartsServiceProvider',
    ],
  ],
  'craftsys/msg91-laravel' => [
    'aliases' => [
      'Msg91' => 'Craftsys\\Msg91\\Facade\\Msg91',
    ],
    'providers' => [
      0 => 'Craftsys\\Msg91\\Msg91LaravelServiceProvider',
    ],
  ],
  'craftsys/msg91-laravel-notification-channel' => [
    'providers' => [
      0 => 'Craftsys\\Notifications\\Msg91ChannelServiceProvider',
    ],
  ],
  'cyrildewit/eloquent-viewable' => [
    'providers' => [
      0 => 'CyrildeWit\\EloquentViewable\\EloquentViewableServiceProvider',
    ],
  ],
  'devmarketer/easynav' => [
    'providers' => [
      0 => 'DevMarketer\\EasyNav\\EasyNavServiceProvider',
    ],
    'aliases' => [
      'Nav' => 'DevMarketer\\EasyNav\\EasyNavFacade',
    ],
  ],
  'fideloper/proxy' => [
    'providers' => [
      0 => 'Fideloper\\Proxy\\TrustedProxyServiceProvider',
    ],
  ],
  'fruitcake/laravel-cors' => [
    'providers' => [
      0 => 'Fruitcake\\Cors\\CorsServiceProvider',
    ],
  ],
  'htmlmin/htmlmin' => [
    'providers' => [
      0 => 'HTMLMin\\HTMLMin\\HTMLMinServiceProvider',
    ],
    'aliases' => [
      'HTMLMin' => 'HTMLMin\\HTMLMin\\Facades\\HTMLMin',
    ],
  ],
  'imanghafoori/laravel-microscope' => [
    'providers' => [
      0 => 'Imanghafoori\\LaravelMicroscope\\LaravelMicroscopeServiceProvider',
    ],
  ],
  'intervention/image' => [
    'providers' => [
      0 => 'Intervention\\Image\\ImageServiceProvider',
    ],
    'aliases' => [
      'Image' => 'Intervention\\Image\\Facades\\Image',
    ],
  ],
  'itskodinger/midia' => [
    'providers' => [
      0 => 'Itskodinger\\Midia\\MidiaServiceProvider',
    ],
  ],
  'jackiedo/dotenv-editor' => [
    'providers' => [
      0 => 'Jackiedo\\DotenvEditor\\DotenvEditorServiceProvider',
    ],
    'aliases' => [
      'DotenvEditor' => 'Jackiedo\\DotenvEditor\\Facades\\DotenvEditor',
    ],
  ],
  'jackiedo/timezonelist' => [
    'providers' => [
      0 => 'Jackiedo\\Timezonelist\\TimezonelistServiceProvider',
    ],
  ],
  'jenssegers/agent' => [
    'providers' => [
      0 => 'Jenssegers\\Agent\\AgentServiceProvider',
    ],
    'aliases' => [
      'Agent' => 'Jenssegers\\Agent\\Facades\\Agent',
    ],
  ],
  'joedixon/laravel-translation' => [
    'providers' => [
      0 => 'JoeDixon\\Translation\\TranslationServiceProvider',
      1 => 'JoeDixon\\Translation\\TranslationBindingsServiceProvider',
    ],
  ],
  'jorenvanhocht/laravel-share' => [
    'providers' => [
      0 => 'Jorenvh\\Share\\Providers\\ShareServiceProvider',
    ],
    'aliases' => [
      'Share' => 'Jorenvh\\Share\\ShareFacade',
    ],
  ],
  'kingflamez/laravelrave' => [
    'providers' => [
      0 => 'KingFlamez\\Rave\\RaveServiceProvider',
    ],
    'aliases' => [
      'Rave' => 'KingFlamez\\Rave\\Facades\\Rave',
    ],
  ],
  'laravel-notification-channels/onesignal' => [
    'providers' => [
      0 => 'NotificationChannels\\OneSignal\\OneSignalServiceProvider',
    ],
  ],
  'laravel/legacy-factories' => [
    'providers' => [
      0 => 'Illuminate\\Database\\Eloquent\\LegacyFactoryServiceProvider',
    ],
  ],
  'laravel/passport' => [
    'providers' => [
      0 => 'Laravel\\Passport\\PassportServiceProvider',
    ],
  ],
  'laravel/socialite' => [
    'providers' => [
      0 => 'Laravel\\Socialite\\SocialiteServiceProvider',
    ],
    'aliases' => [
      'Socialite' => 'Laravel\\Socialite\\Facades\\Socialite',
    ],
  ],
  'laravel/tinker' => [
    'providers' => [
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ],
  ],
  'laravel/ui' => [
    'providers' => [
      0 => 'Laravel\\Ui\\UiServiceProvider',
    ],
  ],
  'laravolt/avatar' => [
    'providers' => [
      0 => 'Laravolt\\Avatar\\ServiceProvider',
    ],
    'aliases' => [
      'Avatar' => 'Laravolt\\Avatar\\Facade',
    ],
  ],
  'mews/purifier' => [
    'providers' => [
      0 => 'Mews\\Purifier\\PurifierServiceProvider',
    ],
    'aliases' => [
      'Purifier' => 'Mews\\Purifier\\Facades\\Purifier',
    ],
  ],
  'mollie/laravel-mollie' => [
    'providers' => [
      0 => 'Mollie\\Laravel\\MollieServiceProvider',
    ],
    'aliases' => [
      'Mollie' => 'Mollie\\Laravel\\Facades\\Mollie',
    ],
  ],
  'mtownsend/read-time' => [
    'providers' => [
      0 => 'Mtownsend\\ReadTime\\Providers\\ReadTimeServiceProvider',
    ],
  ],
  'nesbot/carbon' => [
    'providers' => [
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ],
  ],
  'nunomaduro/collision' => [
    'providers' => [
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ],
  ],
  'nwidart/laravel-modules' => [
    'providers' => [
      0 => 'Nwidart\\Modules\\LaravelModulesServiceProvider',
    ],
    'aliases' => [
      'Module' => 'Nwidart\\Modules\\Facades\\Module',
    ],
  ],
  'obydul/laraskrill' => [
    'providers' => [
      0 => 'Obydul\\LaraSkrill\\LaraSkrillServiceProvider',
    ],
  ],
  'orangehill/iseed' => [
    'providers' => [
      0 => 'Orangehill\\Iseed\\IseedServiceProvider',
    ],
  ],
  'pragmarx/google2fa-laravel' => [
    'providers' => [
      0 => 'PragmaRX\\Google2FALaravel\\ServiceProvider',
    ],
    'aliases' => [
      'Google2FA' => 'PragmaRX\\Google2FALaravel\\Facade',
    ],
  ],
  'qoraiche/laravel-mail-editor' => [
    'providers' => [
      0 => 'Qoraiche\\MailEclipse\\MailEclipseServiceProvider',
    ],
    'aliases' => [
      'MailEclipse' => 'Qoraiche\\MailEclipse\\Facades\\MailEclipse',
    ],
  ],
  'rap2hpoutre/fast-excel' => [
    'providers' => [
      0 => 'Rap2hpoutre\\FastExcel\\Providers\\FastExcelServiceProvider',
    ],
  ],
  'revolution/socialite-amazon' => [
    'providers' => [
      0 => 'Revolution\\Socialite\\Amazon\\AmazonServiceProvider',
    ],
  ],
  'samuelnitsche/laravel-auth-log' => [
    'providers' => [
      0 => 'SamuelNitsche\\AuthLog\\AuthLogServiceProvider',
    ],
  ],
  'shipu/php-aamarpay-payment' => [
    'providers' => [
      0 => 'Shipu\\Aamarpay\\AamarpayServiceProvider',
    ],
    'aliases' => [
      'Aamarpay' => 'Shipu\\Aamarpay\\Facades\\Aamarpay',
    ],
  ],
  'silviolleite/laravelpwa' => [
    'providers' => [
      0 => 'LaravelPWA\\Providers\\LaravelPWAServiceProvider',
    ],
  ],
  'simplesoftwareio/simple-qrcode' => [
    'providers' => [
      0 => 'SimpleSoftwareIO\\QrCode\\QrCodeServiceProvider',
    ],
    'aliases' => [
      'QrCode' => 'SimpleSoftwareIO\\QrCode\\Facades\\QrCode',
    ],
  ],
  'spatie/laravel-analytics' => [
    'providers' => [
      0 => 'Spatie\\Analytics\\AnalyticsServiceProvider',
    ],
    'aliases' => [
      'Analytics' => 'Spatie\\Analytics\\AnalyticsFacade',
    ],
  ],
  'spatie/laravel-backup' => [
    'providers' => [
      0 => 'Spatie\\Backup\\BackupServiceProvider',
    ],
  ],
  'spatie/laravel-cookie-consent' => [
    'providers' => [
      0 => 'Spatie\\CookieConsent\\CookieConsentServiceProvider',
    ],
  ],
  'spatie/laravel-googletagmanager' => [
    'providers' => [
      0 => 'Spatie\\GoogleTagManager\\GoogleTagManagerServiceProvider',
    ],
    'aliases' => [
      'GoogleTagManager' => 'Spatie\\GoogleTagManager\\GoogleTagManagerFacade',
    ],
  ],
  'spatie/laravel-image-optimizer' => [
    'providers' => [
      0 => 'Spatie\\LaravelImageOptimizer\\ImageOptimizerServiceProvider',
    ],
    'aliases' => [
      'ImageOptimizer' => 'Spatie\\LaravelImageOptimizer\\Facades\\ImageOptimizer',
    ],
  ],
  'spatie/laravel-newsletter' => [
    'providers' => [
      0 => 'Spatie\\Newsletter\\NewsletterServiceProvider',
    ],
    'aliases' => [
      'Newsletter' => 'Spatie\\Newsletter\\NewsletterFacade',
    ],
  ],
  'spatie/laravel-permission' => [
    'providers' => [
      0 => 'Spatie\\Permission\\PermissionServiceProvider',
    ],
  ],
  'spatie/laravel-sitemap' => [
    'providers' => [
      0 => 'Spatie\\Sitemap\\SitemapServiceProvider',
    ],
  ],
  'spatie/laravel-translatable' => [
    'providers' => [
      0 => 'Spatie\\Translatable\\TranslatableServiceProvider',
    ],
  ],
  'tanmuhittin/laravel-google-translate' => [
    'providers' => [
      0 => 'Tanmuhittin\\LaravelGoogleTranslate\\LaravelGoogleTranslateServiceProvider',
    ],
  ],
  'tohidplus/laravel-vue-translation' => [
    'providers' => [
      0 => 'Tohidplus\\Translation\\TranslationServiceProvider',
    ],
  ],
  'torann/currency' => [
    'providers' => [
      0 => 'Torann\\Currency\\CurrencyServiceProvider',
    ],
    'aliases' => [
      'Currency' => 'Torann\\Currency\\Facades\\Currency',
    ],
  ],
  'torann/geoip' => [
    'providers' => [
      0 => 'Torann\\GeoIP\\GeoIPServiceProvider',
    ],
    'aliases' => [
      'GeoIP' => 'Torann\\GeoIP\\Facades\\GeoIP',
    ],
  ],
  'tzsk/payu' => [
    'providers' => [
      0 => 'Tzsk\\Payu\\PayuServiceProvider',
    ],
    'aliases' => [
      'Payu' => 'Tzsk\\Payu\\Facades\\Payu',
    ],
  ],
  'unicodeveloper/laravel-paystack' => [
    'providers' => [
      0 => 'Unicodeveloper\\Paystack\\PaystackServiceProvider',
    ],
    'aliases' => [
      'Paystack' => 'Unicodeveloper\\Paystack\\Facades\\Paystack',
    ],
  ],
  'uxweb/sweet-alert' => [
    'providers' => [
      0 => 'UxWeb\\SweetAlert\\SweetAlertServiceProvider',
    ],
    'aliases' => [
      'Alert' => 'UxWeb\\SweetAlert\\SweetAlert',
    ],
  ],
  'weblagence/laravel-facebook-pixel' => [
    'providers' => [
      0 => 'WebLAgence\\LaravelFacebookPixel\\LaravelFacebookPixelServiceProvider',
    ],
    'aliases' => [
      'LaravelFacebookPixel' => 'WebLAgence\\LaravelFacebookPixel\\LaravelFacebookPixelFacade',
    ],
  ],
  'yajra/laravel-datatables-oracle' => [
    'providers' => [
      0 => 'Yajra\\DataTables\\DataTablesServiceProvider',
    ],
    'aliases' => [
      'DataTables' => 'Yajra\\DataTables\\Facades\\DataTables',
    ],
  ],
  'yoeunes/notify' => [
    'providers' => [
      0 => 'Yoeunes\\Notify\\NotifyServiceProvider',
    ],
    'aliases' => [
      'Notify' => 'Yoeunes\\Notify\\Facades\\Notify',
    ],
  ],
];
