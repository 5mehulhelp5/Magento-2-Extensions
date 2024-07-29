<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Model;

/**
 * Class Providers
 * @package Magexperts\Smtp\Model
 */
class Providers
{
    /**
     * @return array
     */
    public function getAllProviders()
    {
        return [
            'gmail' => [
                'label' => __('Gmail, GSuite'),
                'info' => [
                    'host' => 'smtp.gmail.com',
                    'port' => '465',
                    'encryption' => 'ssl',
                    'auth_type' => 'login'
                ]
            ],
            'yandex' => [
                'label' => __('Yandex'),
                'info' => [
                    'host' => 'smtp.yandex.ru',
                    'port' => '465',
                    'encryption' => 'ssl',
                    'auth_type' => 'login'
                ]
            ],
            'amazon-us-east-virginia' => [
                'label' => __('Amazon SES: US East (N. Virginia)'),
                'info' => [
                    'host' => 'email-smtp.us-east-1.amazonaws.com',
                    'port' => '587',
                    'encryption' => 'tls',
                    'auth_type' => 'login'
                ]
            ],
            'amazon-us-east-oregon' => [
                'label' => __('Amazon SES: US West (Oregon)'),
                'info' => [
                    'host' => 'email-smtp.us-west-2.amazonaws.com',
                    'port' => '587',
                    'encryption' => 'tls',
                    'auth_type' => 'login'
                ]
            ],
            'amazon-eu-ireland' => [
                'label' => __('Amazon SES: EU (Ireland)'),
                'info' => [
                    'host' => 'email-smtp.eu-west-1.amazonaws.com',
                    'port' => '587',
                    'encryption' => 'tls',
                    'auth_type' => 'login'
                ]
            ],
            'mailgun' => [
                'label' => __('Mailgun'),
                'info' => [
                    'host' => 'smtp.mailgun.org',
                    'port' => '587',
                    'encryption' => 'tls',
                    'auth_type' => 'login'
                ]
            ],
            'mandrill' => [
                'label' => __('Mandrill'),
                'info' => [
                    'host' => 'smtp.mandrillapp.com',
                    'port' => '587',
                    'encryption' => 'tls',
                    'auth_type' => 'login'
                ]
            ],
            'sendinblue' => [
                'label' => __('Sendinblue'),
                'info' => [
                    'host' => 'smtp-relay.sendinblue.com',
                    'port' => '587',
                    'encryption' => 'tls',
                    'auth_type' => 'login'
                ]
            ],
            'sendgrid' => [
                'label' => __('Sendgrid'),
                'info' => [
                    'host' => 'smtp.sendgrid.net',
                    'port' => '587',
                    'encryption' => 'tls',
                    'auth_type' => 'login'
                ]
            ],
            'elastic' => [
                'label' => __('Elastic Email'),
                'info' => [
                    'host' => 'smtp.elasticemail.com',
                    'port' => '2525',
                    'encryption' => '',
                    'auth_type' => 'login'
                ]
            ],
            'sparkpost' => [
                'label' => __('SparkPost'),
                'info' => [
                    'host' => 'smtp.sparkpostmail.com',
                    'port' => '587',
                    'encryption' => 'tls',
                    'auth_type' => 'login'
                ]
            ],
            'mailjet' => [
                'label' => __('Mailjet'),
                'info' => [
                    'host' => 'in-v3.mailjet.com',
                    'port' => '587',
                    'encryption' => 'tls',
                    'auth_type' => 'login'
                ]
            ],
            'postmark' => [
                'label' => __('Postmark'),
                'info' => [
                    'host' => 'smtp.postmarkapp.com',
                    'port' => '587',
                    'encryption' => 'tls',
                    'auth_type' => 'login'
                ]
            ],
            'aol' => [
                'label' => __('AOL Mail'),
                'info' => [
                    'host' => 'smtp.aol.com',
                    'port' => '587',
                    'encryption' => '',
                    'auth_type' => 'login'
                ]
            ],
            'comcast' => [
                'label' => __('Comcast'),
                'info' => [
                    'host' => 'smtp.comcast.net',
                    'port' => '587',
                    'encryption' => '',
                    'auth_type' => 'login'
                ]
            ],
            'gmx' => [
                'label' => __('GMX'),
                'info' => [
                    'host' => 'mail.gmx.net',
                    'port' => '587',
                    'encryption' => 'tls',
                    'auth_type' => 'login'
                ]
            ],
            'hotmail' => [
                'label' => __('Hotmail'),
                'info' => [
                    'host' => 'smtp-mail.outlook.com',
                    'port' => '587',
                    'encryption' => 'tls',
                    'auth_type' => 'login'
                ]
            ],
            'mailcom' => [
                'label' => __('Mail.com'),
                'info' => [
                    'host' => 'smtp.mail.com',
                    'port' => '587',
                    'encryption' => '',
                    'auth_type' => 'login'
                ]
            ],
            '02mail' => [
                'label' => __('O2 Mail'),
                'info' => [
                    'host' => 'smtp.o2.ie',
                    'port' => '25',
                    'encryption' => '',
                    'auth_type' => 'login'
                ]
            ],
            'office365' => [
                'label' => __('Office365'),
                'info' => [
                    'host' => 'smtp.office365.com',
                    'port' => '587',
                    'encryption' => '',
                    'auth_type' => 'login'
                ]
            ],
            'orange' => [
                'label' => __('Orange'),
                'info' => [
                    'host' => 'smtp.orange.net',
                    'port' => '25',
                    'encryption' => '',
                    'auth_type' => 'login'
                ]
            ],
            'outlook' => [
                'label' => __('Outlook'),
                'info' => [
                    'host' => 'smtp-mail.outlook.com',
                    'port' => '587',
                    'encryption' => 'tls',
                    'auth_type' => 'login'
                ]
            ],
            'yahoo' => [
                'label' => __('Yahoo Mail'),
                'info' => [
                    'host' => 'smtp.mail.yahoo.com',
                    'port' => '465',
                    'encryption' => 'ssl',
                    'auth_type' => 'login'
                ]
            ],
            'yahooplus' => [
                'label' => __('Yahoo Mail Plus'),
                'info' => [
                    'host' => 'plus.smtp.mail.yahoo.com',
                    'port' => '465',
                    'encryption' => 'ssl',
                    'auth_type' => 'login'
                ]
            ],
            'yahooau' => [
                'label' => __('Yahoo AU/NZ'),
                'info' => [
                    'host' => 'smtp.mail.yahoo.com.au',
                    'port' => '465',
                    'encryption' => 'ssl',
                    'auth_type' => 'login'
                ]
            ],
            'at&t' => [
                'label' => __('AT&T'),
                'info' => [
                    'host' => 'smtp.att.yahoo.com',
                    'port' => '465',
                    'encryption' => 'ssl',
                    'auth_type' => 'login'
                ]
            ],
            'ntlworld' => [
                'label' => __('NTL @ntlworld.com'),
                'info' => [
                    'host' => 'smtp.ntlworld.com',
                    'port' => '465',
                    'encryption' => 'ssl',
                    'auth_type' => 'login'
                ]
            ],
            'btconnect' => [
                'label' => __('BT Connect'),
                'info' => [
                    'host' => 'pop3.btconnect.com',
                    'port' => '25',
                    'encryption' => '',
                    'auth_type' => 'login'
                ]
            ],
            'zoho' => [
                'label' => __('Zoho Mail'),
                'info' => [
                    'host' => 'smtp.zoho.com',
                    'port' => '465',
                    'encryption' => 'ssl',
                    'auth_type' => 'login'
                ]
            ],
            'verizon' => [
                'label' => __('Verizon'),
                'info' => [
                    'host' => 'outgoing.verizon.net',
                    'port' => '465',
                    'encryption' => 'ssl',
                    'auth_type' => 'login'
                ]
            ],
            'btopenworld' => [
                'label' => __('BT Openworld'),
                'info' => [
                    'host' => 'mail.btopenworld.com',
                    'port' => '25',
                    'encryption' => '',
                    'auth_type' => 'login'
                ]
            ],
            'o2online' => [
                'label' => __('O2 Online Deutschland'),
                'info' => [
                    'host' => 'mail.o2online.de',
                    'port' => '25',
                    'encryption' => '',
                    'auth_type' => 'login'
                ]
            ],
            '1&1webmail' => [
                'label' => __('1&1 Webmail'),
                'info' => [
                    'host' => 'smtp.1and1.com',
                    'port' => '587',
                    'encryption' => '',
                    'auth_type' => 'login'
                ]
            ],
            'ovh' => [
                'label' => __('OVH'),
                'info' => [
                    'host' => 'ssl0.ovh.net',
                    'port' => '465',
                    'encryption' => 'ssl',
                    'auth_type' => 'login'
                ]
            ],
            'smtp2go' => [
                'label' => __('SMTP2GO'),
                'info' => [
                    'host' => 'mail.smtp2go.com',
                    'port' => '2525',
                    'encryption' => 'tls',
                    'auth_type' => 'login'
                ]
            ]
        ];
    }
}
