<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',

            //Belongs to many relations
            'roles' => 'Roles',

        ],
    ],

    'user' => [
        'title' => 'User',

        'actions' => [
            'index' => 'User',
            'create' => 'New User',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',

        ],
    ],

    'post' => [
        'title' => 'Posts',

        'actions' => [
            'index' => 'Posts',
            'create' => 'New Post',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'post_name' => 'Post name',
            'deleted' => 'Deleted',

        ],
    ],

    'user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'surname' => 'Surname',
            'first_name' => 'First name',
            'second_name' => 'Second name',
            'passport_series' => 'Passport series',
            'passport_number' => 'Passport number',
            'inn' => 'Inn',
            'scan' => 'Scan',
            'birthday' => 'Birthday',
            'deleted' => 'Deleted',
            'dismissed' => 'Dismissed',
            'api_token' => 'Api token',

        ],
    ],

    'city' => [
        'title' => 'Cities',

        'actions' => [
            'index' => 'Cities',
            'create' => 'New City',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'city_name' => 'City name',
            'deleted' => 'Deleted',

        ],
    ],

    'office' => [
        'title' => 'Offices',

        'actions' => [
            'index' => 'Offices',
            'create' => 'New Office',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'phone' => 'Phone',
            'address' => 'Address',
            'city_id' => 'City',
            'deleted' => 'Deleted',

        ],
    ],

    'route' => [
        'title' => 'Routes',

        'actions' => [
            'index' => 'Routes',
            'create' => 'New Route',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'departure_city_id' => 'Departure city',
            'arrival_city_id' => 'Arrival city',
            'distance' => 'Distance',
            'user_id' => 'User',
            'deleted' => 'Deleted',

        ],
    ],

    'model' => [
        'title' => 'Models',

        'actions' => [
            'index' => 'Models',
            'create' => 'New Model',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'model_name' => 'Model name',
            'deleted' => 'Deleted',

        ],
    ],

    'transport' => [
        'title' => 'Transports',

        'actions' => [
            'index' => 'Transports',
            'create' => 'New Transport',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'car_number' => 'Car number',
            'total_seats' => 'Total seats',
            'model_id' => 'Model',
            'deleted' => 'Deleted',

        ],
    ],

    'schedule' => [
        'title' => 'Schedules',

        'actions' => [
            'index' => 'Schedules',
            'create' => 'New Schedule',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'date' => 'Date',
            'time' => 'Time',
            'cost' => 'Cost',
            'confirmed' => 'Confirmed',
            'transport_id' => 'Transport',
            'route_id' => 'Route',
            'deleted' => 'Deleted',

        ],
    ],

    'passenger' => [
        'title' => 'Passengers',

        'actions' => [
            'index' => 'Passengers',
            'create' => 'New Passenger',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'surname' => 'Surname',
            'first_name' => 'First name',
            'second_name' => 'Second name',
            'passport_series' => 'Passport series',
            'passport_number' => 'Passport number',
            'phone' => 'Phone',
            'deleted' => 'Deleted',

        ],
    ],

    'ticket' => [
        'title' => 'Tickets',

        'actions' => [
            'index' => 'Tickets',
            'create' => 'New Ticket',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'passenger_id' => 'Passenger',
            'schedule_id' => 'Schedule',
            'deleted' => 'Deleted',

        ],
    ],

    'post-user' => [
        'title' => 'Post Users',

        'actions' => [
            'index' => 'Post Users',
            'create' => 'New Post User',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'user_id' => 'User',
            'post_id' => 'Post',
            'deleted' => 'Deleted',

        ],
    ],

    'office-user' => [
        'title' => 'Office Users',

        'actions' => [
            'index' => 'Office Users',
            'create' => 'New Office User',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'user_id' => 'User',
            'office_id' => 'Office',
            'deleted' => 'Deleted',

        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
