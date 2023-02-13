<?php

final class ComponentSheets
{

    public function get_data(): array
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

// Crea una solicitud HTTP POST con cURL para obtener el token de acceso
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://oauth2.googleapis.com/token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Envía la solicitud y recibe la respuesta
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

// Verifica si la respuesta es válida
        if ($http_status != 200) {
            // Manusea el error aquí
            exit();
        }

// Decodifica la respuesta JSON
        $data = json_decode($response, true);

// Obtén el token de acceso
        $access_token = $data["access_token"];

// Configura los detalles de la solicitud para consumir la hoja de cálculo
        $spreadsheet_id = "your-spreadsheet-id";
        $range = "Sheet1!A1:D4";

// Crea una solicitud HTTP GET con cURL para consumir la hoja de cálculo
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://sheets.googleapis.com/v4/spreadsheets/" . $spreadsheet_id . "/values/" . $range);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $access_token,
            "Accept: application/json",
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Envía la solicitud y recibe la respuesta
        $response = curl_exec($ch);
    }
}