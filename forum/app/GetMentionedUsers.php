<?php

namespace App;

use Auth;
use Illuminate\Support\Collection;

class GetMentionedUsers
{
    /**
     * Returns a collection of users who were '@mentioned' in a string of data.
     *
     * @return Illuminate\Support\Collection
     */
    public static function handle(string $data)
    {
        $matches = [];
        $mentioned_users = new Collection();

        // get usernames mentioned and put into $matches
        preg_match_all('/\@\w+/', $data, $matches);

        foreach ($matches[0] as $match) {
            // get User objects from mentioned @usernames
            $mentioned_users->push(User::where('name', str_replace('@', '', $match))->first());
        }

        if (count($mentioned_users)) {
            // remove null value in Collection and remove current user from list of mentioned users, we don't want to email them about mentioning themselves, if they happen to..
            $mentioned_users = $mentioned_users->reject(function ($value, $key) {
                if ($value !== null) {
                    return $value->id === Auth::user()->id;
                }

                return true;
            });
        }

        return $mentioned_users;
    }
}
