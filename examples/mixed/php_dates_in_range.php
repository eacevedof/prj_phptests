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
    //private array $history = ["start"=>"", "end" => ""];

    private array $result = [
        "request" => ["start"=>"", "end" => ""],
        "forecast" => ["start"=>"", "end" => ""],
        "history" => ["start"=>"", "end" => ""],
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
        if (($reqend = $this->request["end"]) >= ($forend = $this->forecast["end"])) {
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

        //Hay q recordar que el día 1 almacena el dato de todo el mes
        //o habría que obtener del mes actual y del siguiente?
        $day = date("d", $seconds = strtotime($reqend));
        $nextmonth = ($day==="01")
            ? date("Y-m-01", $seconds)
            : date("Y-m-01", strtotime("+1 month", $seconds));
        $this->result["forecast"]["end"] = $nextmonth;
    }

    private function _calc_starts(): void
    {
        if (($reqstart = $this->request["start"]) <= ($forstart = $this->forecast["start"])) {
            $this->result["forecast"]["start"] = $forstart;
            $this->result["history"]["start"] = $reqstart;
            return;
        }

        //reqstart > forstart

/*
        $day = date("d", $seconds = strtotime($reqstart));
        $prevmonth = ($day==="01")
            ? date("Y-m-01", $seconds)
            : date("Y-m-01", strtotime("+1 month", $seconds));
*/
        $start = date("Y-m-01", strtotime($reqstart));
        //forecast debe ser el mes previo con dia 1
        $this->result["forecast"]["start"] = $start;
        $this->result["history"]["start"] = $start;
    }
}

$request = [
    //["start" => "2022-03-01", "end" => "2022-09-01"],
    //["start" => "2022-03-01", "end" => "2022-08-13"],
    //["start" => "2022-03-01", "end" => "2022-12-01"],
    //["start" => "2022-03-01", "end" => "2023-01-03"],
    //["start" => "2022-03-01", "end" => "2023-01-03"],
    ["start" => "2022-03-13", "end" => "2023-01-03"],
];

$forecast = [
    //["start" => "2022-03-01", "end" => "2022-09-01"],
    //["start" => "2022-03-01", "end" => "2022-08-01"],
    //["start" => "2022-03-01", "end" => "2022-10-01"],
    ["start" => "2022-02-01", "end" => "2022-12-01"],
];

foreach($request as $i => $req) {
    bug($req, "req-date");
    bug($forecast[$i], "forecast-range");
    $r = (new IntersectHelper())
        ->set_request($req["start"], $req["end"])
        ->set_forecast($forecast[$i]["start"], $forecast[$i]["end"])
        ->get_calculated()
    ;
    pr($r);
}