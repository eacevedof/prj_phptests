<?php
/**
 * @file: php_di.php
 * @info: ensayos con el inyector de dependencias php-di 6.0: http://php-di.org/
 */
include("vendor/autoload.php");

final class IntersectHelper
{
    private array $request = ["start"=>"", "end" => ""];
    private array $forecast = ["start"=>"", "end" => ""];
    private array $history = ["start"=>"", "end" => ""];

    private array $result = [
        "request" => ["start"=>"", "end" => ""],
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

    public function set_history(string $start, $end): self
    {
        $this->history = ["start" => $start, "end" => $end];
        return $this;
    }

    public function get_calculated(): array
    {
        $this->result["request"]["start"] = $this->request["start"];
        $this->result["request"]["end"] = $this->request["end"];

        return $this->result;
    }
}

$request = [
    ["start" => "2022-01-01", "end" => "2022-01-01"],
];

$forecast = [
    ["start" => "2022-01-01", "end" => "2022-01-01"],
];

$history = [
    ["start" => "2022-01-01", "end" => "2022-01-01"],
];

foreach($request as $req) {
    $r = (new IntersectHelper())
        ->set_request()
        ->set_history()
        ->set_forecast()
    ;
    pr($r);
}