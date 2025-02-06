<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat', function ($user) {
    return true;
});

/**
 * This channel is used to send messages to the specific user
 */
Broadcast::channel('admin.chat.{user_id}', function ($user, $user_id) {
    return (int) $user->id === (int) $user_id;
});

/**
 * This channel is used to send messages to the specific user
 */
Broadcast::channel('admin.chat', function () {
    return auth()->check();
});
