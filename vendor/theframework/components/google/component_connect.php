<?php

namespace TheFramework\Components\Google;

final class ComponentConnect
{
    private static string $bearer = "";
    private const URL_AUTH = "https://oauth2.googleapis.com/token";

    private const GOOGLE_CLIENT_ID = "your-client-id.apps.googleusercontent.com";
    private const GOOGLE_CLIENT_SECRET = "your-client-secret";
    private const GOOGLE_REDIRECT_URI = "urn:ietf:wg:oauth:2.0:oob";
    private const GOOGLE_GRANT_TYPE = "authorization_code";
    private const GOOGLE_AUTHORIZATION_CODE = "your-authorization-code";

    public function get_token(): string
    {
        if (!self::$bearer) {
            $this->connect();
        }
        return self::$bearer;
    }

    private function connect(): void
    {
        $ch = curl_init();
        $postPayload = http_build_query($this->get_credentials());
        curl_setopt($ch, CURLOPT_URL, self::URL_AUTH);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postPayload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpStatus != 200) {
            //exit();
        }

// Decodifica la respuesta JSON
        $data = json_decode($response, true);
// Obtén el token de acceso
        self::$bearer = $data["access_token"] ?? "";
    }

    private function get_credentials(): array
    {
        return [
            "code" => self::GOOGLE_AUTHORIZATION_CODE,
            "client_id" => self::GOOGLE_CLIENT_ID,
            "client_secret" => self::GOOGLE_CLIENT_SECRET,
            "redirect_uri" => self::GOOGLE_REDIRECT_URI,
            "grant_type" => self::GOOGLE_GRANT_TYPE,
        ];
    }
}