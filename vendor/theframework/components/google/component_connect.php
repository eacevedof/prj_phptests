<?php

namespace TheFramework\Components\Google;

final class ComponentConnect
{
    private static string $bearer = "";

    public function get_token(): string
    {

    }

    private function connect(): void
    {
        // Configura los detalles de la solicitud de autenticación
        $client_id = "your-client-id.apps.googleusercontent.com";
        $client_secret = "your-client-secret";
        $redirect_uri = "urn:ietf:wg:oauth:2.0:oob";
        $grant_type = "authorization_code";
        $code = "your-authorization-code";

// Crea la solicitud de autenticación
        $data = [
            "code" => $code,
            "client_id" => $client_id,
            "client_secret" => $client_secret,
            "redirect_uri" => $redirect_uri,
            "grant_type" => $grant_type,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://oauth2.googleapis.com/token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Envía la solicitud y recibe la respuesta
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    }

    private function get_credentials(): array
    {

    }
}