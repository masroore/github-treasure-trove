<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable / Disable auto save
    |--------------------------------------------------------------------------
    |
    | Auto-save every time the application shuts down
    |
    */
    'auto_save' => true,

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | Options for caching. Set whether to enable cache, its key, time to live
    | in seconds and whether to auto clear after save.
    |
    */
    'cache' => [
        'enabled' => false,
        'key' => 'setting',
        'ttl' => 3600,
        'auto_clear' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Setting driver
    |--------------------------------------------------------------------------
    |
    | Select where to store the settings.
    |
    | Supported: "database", "json", "memory"
    |
    */
    'driver' => 'json',

    /*
    |--------------------------------------------------------------------------
    | Database driver
    |--------------------------------------------------------------------------
    |
    | Options for database driver. Enter which connection to use, null means
    | the default connection. Set the table and column names.
    |
    */
    'database' => [
        'connection' => null,
        'table' => 'settings',
        'key' => 'key',
        'value' => 'value',
    ],

    /*
    |--------------------------------------------------------------------------
    | Override application config values
    |--------------------------------------------------------------------------
    |
    | If defined, settings package will override these config values.
    |
    | Sample:
    |   "app.locale" => "settings.locale",
    |
    */
    'override' => [
        'app.name' => 'app_name',
        'app.env' => 'app_env',
        'app.debug' => 'app_debug',
        'app.url' => 'app_url',
        'app.locale' => 'app_locale',
        'mail.driver' => 'mail_driver',
        'mail.host' => 'mail_host',
        'mail.port' => 'mail_port',
        'mail.from.address' => 'mail_from_address',
        'mail.from.name' => 'mail_from_name',
        'mail.encryption' => 'mail_encryption',
        'mail.username' => 'mail_username',
        'mail.password' => 'mail_password',
        'mail.mailgun.domian' => 'mail_mailgun_domain',
        'mail.mailgun.secret' => 'mail_mailgun_secret',
        'database.connections.mysql.host' => 'db_mysql_host',
        'database.connections.mysql.port' => 'db_mysql_port',
        'database.connections.mysql.database' => 'db_mysql_database',
        'database.connections.mysql.username' => 'db_mysql_username',
        'database.connections.mysql.password' => 'db_mysql_password',
        'database.connections.mysql.dump.dump_binary_path' => 'db_mysql_dump_path',
        'pdf.created' => 'app_name',
        'backup.notifications.mail.to' => 'backup_email_to',
        'backup.notifications.mail.from.address' => 'mail_from_address',
        'backup.notifications.mail.from.name' => 'mail_from_name',
        'recaptcha.api_site_key' => 'recaptcha_site_key',
        'recaptcha.api_secret_key' => 'recaptcha_secret_key',
        'recaptcha.version' => 'recaptcha_version',
        'recaptcha.default_language' => 'app_locale',
        'recaptcha.tag_attributes.theme' => 'recaptcha_theme',
        'services.github.client_id' => 'github_client_id',
        'services.github.client_secret' => 'github_client_secret',
        'services.github.redirect' => 'github_redirect',
        'services.facebook.client_id' => 'facebook_client_id',
        'services.facebook.client_secret' => 'facebook_client_secret',
        'services.facebook.redirect' => 'facebook_redirect',
        'services.twitter.client_id' => 'twitter_client_id',
        'services.twitter.client_secret' => 'twitter_client_secret',
        'services.twitter.redirect' => 'twitter_redirect',
    ],

    /*
    |--------------------------------------------------------------------------
    | Required Extra Columns
    |--------------------------------------------------------------------------
    |
    | The list of columns required to be set up
    |
    | Sample:
    |   "user_id",
    |   "tenant_id",
    |
    */
    'required_extra_columns' => [

    ],
];
