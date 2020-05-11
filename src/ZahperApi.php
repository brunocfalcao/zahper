<?php

namespace Brunocfalcao\Zahper;

class ZahperApi
{
    public static function compile(string $mjml)
    {
        $url = config('zahper.api.url');
        $username = config('zahper.api.application_id');
        $password = config('zahper.api.secret_key');

        $ch = curl_init();

        curl_setopt(
            $ch,
            CURLOPT_URL,
            $url
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['mjml' => $mjml]));
        curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);

        $headers = [];
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        }

        $response = json_decode($result);

        curl_close($ch);

        return [
            'html' => $response->html,
            'mjml' => $response->mjml,
            'version' => $response->mjml_version,
            'errors' => $response->errors,
        ];
    }
}
