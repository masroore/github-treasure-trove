<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'login' => [
        'btn' => 'Login',
        'email_error' => 'Please fill in your email address',
        'password_error' => 'Please fill in your password',
        'password_placeholder' => 'Enter your master password',
        'remember' => 'Remember Me',
        'forgot' => 'Forgot Password',
        'new' => 'Don&apos;t have an account? <a href=":register">Create One Now</a>',
    ],
    'register' => [
        'btn' => 'Register',
        'closed' => 'Registrations are Closed.',
        'create' => 'Create an Account',
        'password' => 'Master Password',
        'password_head' => 'What is a Master Password?',
        'password_body' => 'The master password will be used for accessing and authorizing access to and of your vaults. Be sure to pick a strong, difficult to predict password combination. Namely containing atleast 12 characters, digits, symbols and uppercase/lowercase alphabets.',
        'password_placeholder' => 'Enter a master password',
        'password_confirm' => 'Confirm Master Password',
        'password_hint' => 'Password Hint (Optional)',
        'password_hint_head' => 'Add a Password Hint!',
        'password_hint_body' => 'Something to remind you of the password sequence. Do not make it too obvious.',
        'agree' => 'I agree to the <a href=":terms" target="_blank">Terms of Service</a> and <a href=":privacy" target="_blank">Privacy Policy</a> of :app.',
        'registered' => 'Already have an account? <a href=":login">Login In Here</a>',
    ],
    'forgot' => [
        'head' => 'Forgot Your Password? Reset Here',
        'sub' => 'We will send a link to your registered e-mail address',
        'btn' => 'Send Password Reset Link',
        'remember' => 'Remember your password? <a href=":login">Try Signing In</a>',
    ],
    'confirm' => [
        'head' => 'Confirm Master Password',
        'title' => 'Confirm your master password to continue',
        'sub' => 'Please confirm your master password before continuing.',
        'btn' => 'Confirm Password',
        'return' => 'Go Back?',
    ],
    'reset' => [
        'password' => 'Reset Password',
        'sub' => 'Reset your account password using the form below.',
        'master_password' => 'New Master Password',
        'master_password_confirm' => 'Confirm New Master Password',
    ],
    '2fa' => [
        'welcome' => 'Welcome back, :user',
        'title' => 'Two-Factor Authentication (2FA)',
        'sub' => 'Enter your <b class="text-danger">One-Time-Passcode</b> from the Google Authenticator App below:',
        'otp' => 'One Time Passcode',
        'btn' => 'Confirm OTP',
        'no_access' => 'Cannot access your phone?',
        'not_user' => 'Not :user? <a href=":logout">Logout!</a>',
    ],
];
