<?php
/**
 * @file: php_di.php
 * @info: ensayos con el inyector de dependencias php-di 6.0: http://php-di.org/
 */
include("vendor/autoload.php");

$history = [
    ["start" => "", "end" => ""],

];

final class IntersectHelper
{
    private array $request = ["start"=>"", "end" => ""];
    private array $forecast = ["start"=>"", "end" => ""];

    private array $result = [
        "history" => ["start"=>"", "end" => ""],
        "forecast" => ["start"=>"", "end" => ""],
    ];

    public function set_request(string $start, $end): self
    {
        $this->request = ["start" => $start, "end" => $end];
        return $this;
    }

    public function set_forecast(string $start, $end): self
    {
        $this->forecast = ["start" => $start, "end" => $end];
        return $this;
    }

    public function get_calculated(): array
    {

        return $this->result;
    }
}