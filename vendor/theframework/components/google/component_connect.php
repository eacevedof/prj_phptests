<?php

namespace TheFramework\Components\Google;

final class ComponentConnect
{

    private static string $bearer = "";
    private const URL_AUTH = "https://docs.google.com/spreadsheets/d/1n06_yqIB88peex3zNDB5PHCfIAVQhrbLUp0xKocXUsw/export?format=csv";

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

    private function connect()
    {
        $url = "https://docs.google.com/spreadsheets/d/{SPREADSHEET_ID}/export?format=csv";
// Reemplaza {SPREADSHEET_ID} por el ID de la hoja de cálculo de Google que deseas leer
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);
    }

    private function _connect(): void
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