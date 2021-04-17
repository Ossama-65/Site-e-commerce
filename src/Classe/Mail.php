<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key = '00aad39c85760323d5e36eb5bfa0c448';
    private $api_key_secret = '25b24ae943b44df84024b2946d2e539f';

    public function send($to_email, $to_name, $subject,$content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret,true, ['version' => 'v3.1']);
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "ossama.louridi77@gmail.com",
                            'Name' => "Lepascher"
                        ],
                        'To' => [
                            [
                                'Email' => $to_email,
                                'Name' => $to_name
                            ]
                        ],
                        'TemplateID' => 2707180,
                        'TemplateLanguage' => true,
                        'Subject' => $subject,
                        'Variables' => [
                            'content' => $content,
                        ]
                        
                    ]
                ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success();
                }
}