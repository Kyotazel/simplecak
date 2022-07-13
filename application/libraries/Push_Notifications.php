<?php

class Push_Notifications
{

    public function push_notification($title = "", $message = "", $image = "myIcon", $type, $timestamp, $token)
    {

        define('API_ACCESS_KEY', 'AAAAJVtsBbw:APA91bHP1fx7pBqLNbIT2ynDhOWrYCo_jaig8c-cPAkQRPSEMLL8ObSpN6NLcszE-QsMCeJ9gyPVTP_o03TR1dp3SL2az5Ijmqv8ujnBD2ZFrrdc6zzflMfkCtZzvsOLStk8kxj78O18');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token = $token;
        // print_r($token);
        // exit;
        $notification = [
            'data' => [
                'title' => $title,
                'is_background' => FALSE,
                'message' => $message,
                'image' => $image,
                'type' => $type,
                'timestamp' => $timestamp
            ]
        ];
        $extraNotificationData = ["message" => $notification, "moredata" => ''];
        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to' => $token, //single token
            'notification' => $notification,
            'data' => $notification
        ];

        $headers = [
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
