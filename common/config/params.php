<?php

return [
    'adminEmail' => 'mark.qj@gmail.com',
    'supportEmail' => 'mark.qj@gmail.com',
    'user.passwordResetTokenExpire' => 604800,   // 1 week
    'user.emailConfirmUserExpire' => 604800,    // 1 week
    'locationTimeOut' => '60', //seconds -> if the signal is out of this timeout -> push notification: no signal
    'alertListTimeOut' => '604800', //seconds = 1 week -> only display the notification in nearest 7 days.
];
