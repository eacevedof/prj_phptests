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

        $this->_calc_ends();
        $this->_calc_starts();
        return $this->result;
    }

    private function _calc_ends(): void
    {
        //si req-end >= for-end => hasta el fin del forecast history hasta req
        $today = date("Y-m-d");
        if ($reqend = $this->request["end"] >= $forend = $this->forecast["end"]) {
            $this->result["forecast"]["end"] = $forend;
            $this->result["history"]["end"] = $reqend;
            if ($reqend>$today) {
                $this->result["history"]["end"] = $today;
            }
            return;
        }

        //req-end < for-end
        $this->result["history"]["end"] = $reqend;
        if ($reqend>$today) {
            $this->result["history"]["end"] = $today;
        }
        //hay que obtener el mes siguiente de req-end y dejarlo en día 1
        $nextmonth = date("Y-m-01", strtotime("+1 month", strtotime($reqend)));
        $this->result["forecast"]["end"] = $nextmonth;
    }

    private function _calc_starts(): void
    {
        $today = date("Y-m-d");
        if ($reqstart = $this->request["start"] <= $forstart = $this->forecast["start"]) {
            $this->result["forecast"]["start"] = $forstart;
            $this->result["history"]["start"] = $reqstart;
            if ($reqstart>$today) {
                $this->result["history"]["start"] = $today;
            }
            return;
        }
    }
}

$request = [
    ["start" => "2022-03-01", "end" => "2022-09-01"],
];

$history = [
    ["start" => "2022-03-01", "end" => "2022-09-01"],
    ["start" => "2022-01-01", "end" => "2022-01-01"],
];

$forecast = [
    ["start" => "2022-03-01", "end" => "2022-09-01"],
];

foreach($request as $req) {
    $r = (new IntersectHelper())
        ->set_request($req["start"], $req["end"])
        ->set_history($history[0]["start"], $history[0]["end"])
        ->set_forecast($forecast[0]["start"], $forecast[0]["end"])
        ->get_calculated()
    ;
    pr($r);
}