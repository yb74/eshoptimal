<?php

namespace App\CustomClass;

use Mailjet\Client;
use Mailjet\Resources;

class Mail {
    private $api_key ="a38cf84e97806e2b1cc44d0bfa27ed58";
    private $api_key_secret = "c2516f3c4e8302a12776501396d12e03";

    public function send($to_email, $to_name, $subject, $content) {
        $mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "youpijoedjopijoe@hotmail.fr",
                        'Name' => "Johnny"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 2838623,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}
