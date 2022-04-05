<?php

    return [
        'domain' => [
            'error' => 'Domain not found',
        ],
        'photo' => [
            'share' => [
                'already' => 'The photo has already been shared',
                'success' => 'Photo successfully shared',
                'self' => 'Impossible to share yours entity',
            ],
        ],
        'order' => [
            'error' => 'Invalid request',
        ],
        'status' => [
            'allowed' => 'status allowed',
            'forbidden' => 'status forbidden',
        ],
        'notification' => [
            'success' => 'Data saved successfully!',
        ],
        'login' => [
            'already' => 'The login has already been taken',
        ],
        'nickname' => [
            'already' => 'The nickname has already been taken',
        ],
        'update' => [
            'success' => 'Data updated successfully!',
        ],
        'store' => [
            'success' => 'Data saved successfully!',
        ],
        'destroy' => [
            'success' => 'Data deleted successfully!',
            'error' => 'Delete error. You may not have permission or access!',
            'error_children' => 'Delete error! To remove the current element, you need to remove all of its children.',
        ],
        'feedback' => [
            'store' => [
                'success' => 'Feedback sent successfully',
            ],
        ],
        'email' => [
            'fail' => 'Fail',
            'already' => 'Already verified',
            'send' => 'Email Sent',
            'verify' => 'Successfully verified',
            'verify_success' => 'Your email address success verified.',
            'check' => 'Check your email to activate email.',
            'unverify' => 'Your email address is not verified.',
        ],
        'post' => [
            'moderate' => 'The article will be published after moderation.',
            'success' => 'Article published',
            'update' => 'Post updated successfully',
            'delete' => 'Post delete',
            'denies' => 'You are not allowed to edit a post',
            'status' => 'Article status changed',
            'statuses' => [
                'draft' => 'Draft',
                'published' => 'Published',
                'unpublished' => 'Unpublished',
            ],
        ],
        'event' => [
            'author' => [
                'user' => 'User',
                'external' => 'External source',
            ],
            'photo' => [
                'save' => 'Photos to the event have been successfully added',
                'forbidden' => 'Adding photos is prohibited',
            ],
            'user' => [
                'status' => 'User statuses changed',
            ],
            'confirm' => [
                'auto' => 'Тo confirmation needed',
                'manually' => 'Manual confirmation',
            ],
            'privacy' => [
                'open' => 'Open',
                'close' => 'Close',
            ],
            'age' => [
                '16' => '16+',
                '18' => '18+',
                'all' => "doesn't matter",
            ],
            'gender' => [
                'male' => 'Male',
                'female' => 'Female',
                'all' => "Doesn't matter",
            ],
            'attend' => [
                'self' => 'This is your event',
                'send' => 'Application for participation in the event has been sent',
                'success' => 'Application for participation has been successfully submitted',
                'close' => 'Closed event',
                'participant' => 'Now you are a participant in this event!',
                'cancel' => 'You are no longer a participant in this event',
                'annulment' => 'Your application for participation has been canceled',
            ],
            'status' => [
                'waiting' => 'status wait',
                'active' => 'status active',
                'passed' => 'status passed',
            ],
            'share' => [
                'already' => 'The event has already been shared',
                'success' => 'Event successfully shared',
            ],
        ],
        'like' => [
            'already' => [
                'save' => 'Like already save for this entity',
                'delete' => 'Like already delete for this entity',
            ],
            'save' => 'Like save',
            'delete' => 'Unlike save',
        ],
        'share' => [
            'already' => 'The post has already been shared',
            'success' => 'Post successfully shared',
            'self' => 'Impossible to share yours entity',
        ],
        'complaint' => [
            'already' => 'A complaint can only be sent once a day',
            'success' => 'Сomplaint sent successfully',
            'self' => 'it is impossible to write a complaint against yourself',
        ],
        'favorite' => [
            'add' => 'Post add in favorites',
            'remove' => 'Post remove in favorites',
        ],
        'comment' => [
            'save' => 'Comment save',
            'update' => 'Comment update',
            'delete' => 'Comment delete',
            'denies' => 'You are not allowed to edit a comment',
            'permission' => 'Can\'t add a comment',
        ],
        'translation' => [
            'isset' => 'Translation for post already exists',
        ],
        'service' => [
            'moderate' => 'The service will be published after moderation.',
            'denies' => 'You are not allowed to create or update service.',
            'update' => 'Service data updated successfully',
            'delete' => 'Service deleted.',
        ],
        'rating' => [
            'add' => 'Your review has been successfully added',
            'permission' => 'Can\'t add a feedback',
            'denies' => 'You do not have permission to edit the review.',
            'delete' => 'Your review has been deleted.',
        ],
        'subscription' => [
            'add' => 'subscription saved',
            'already' => 'subscription already exist',
            'denies' => 'subscription not fount',
            'unsubscribe' => 'unsubscribe success',
            'error' => 'Unable to create subscription',
        ],
        'user' => [
            'password' => [
                'update' => 'Password updated successfully',
            ],
            'update' => 'Data updated successfully',
            'email' => [
                'already' => 'The email has already been taken',
            ],
            'phone' => [
                'already' => 'The phone has already been taken',
            ],
        ],
        'car' => [
            'save' => 'Car saved',
            'add' => 'Application for adding a car has been sent',
            'denies' => 'You are not allowed to edit a car',
            'delete' => 'Car delete',
            'status' => [
                'moderate' => 'Moderate',
                'published' => 'Published',
            ],
        ],
        'chat' => [
            'read' => 'messages readed',
            'message' => [
                'send' => 'Message sent successfully',
                'update' => 'message updated',
                'delete' => 'message deleted',
            ],
            'conversation' => [
                'delete' => 'Conversation delete',
                'create' => 'Conversation create',
            ],
            'self' => 'error, you can not send email you self',
            'denies' => 'you cannot edit / delete this message',
            'banned' => 'You cannot write messages because the user has banned you',
        ],
        'ban' => [
            'already' => 'The user is already banned!',
            'success' => 'user banned',
            'not-banned' => 'user not banned',
            'delete' => 'ban delete',
        ],
        'media' => [
            'delete' => 'media deleted',
            'error' => 'error while deleting',
        ],

        'actions' => [
            'store' => [
                'success' => 'Data success save!',
            ],
            'update' => [
                'success' => 'Data success update!',
            ],
            'destroy' => [
                'success' => 'Dat success delete!',
                'error' => 'Error delete. Permission dined!',
                'error_children' => 'Error delete! Need delete children.',
            ],
        ],
    ];
