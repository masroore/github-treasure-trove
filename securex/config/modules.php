<?php

return [

    /**
     * ------------------------
     *  Google2FA Module
     * ------------------------.
     *
     * Increases security by enabling 2-Factor Authentication System.
     */
    'google2fa' => [

        'enabled' => true,

    ],

    /**
     * ------------------------
     *  Google reCaptcha Module
     * ------------------------.
     *
     * Requires API & Secret Key from the Google Console - https://developers.google.com/recaptcha/docs/start.
     */
    'recaptcha' => [

        // Enable or Disable the module
        'enabled' => false,
    ],

    /**
     * --------------------
     * Social Logins Module
     * --------------------.
     *
     * This module gives your the option to use Github, Facebook or Twitter to register/login your users into the app.
     */
    'social_logins' => [

        // Enable or Disable the module
        'enabled' => false,

        // Github module config
        'github' => [
            // Enable or Disable the github module
            'enabled' => false,

        ],

        // Facebook module config
        'facebook' => [
            // Enable or Disable the facebook module
            'enabled' => false,

        ],

        // Twitter module config
        'twitter' => [
            // Enable or Disable the twitter module
            'enabled' => false,

        ],
    ],

];
