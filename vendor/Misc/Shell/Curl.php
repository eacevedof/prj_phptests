<?php
namespace Misc\Shell;

final class Curl
{
    private string $logPath = "";
    private string $location = "";
    private array $flags = [];
    private array $headers = [];
    private array $dataRaw = [];
    private string $lastCommand = "";

    public static function getInstance(): self
    {
        return new self();
    }

    public function addFlag(string $flag): self
    {
        $this->flags[] = $flag;
        return $this;
    }

    public function setLocation(string $url): self
    {
        $this->location = $url;
        return $this;
    }

    public function addHeader(string $header,string $value): self
    {
        $this->headers[$header] = $value;
        return $this;
    }

    public function addDataRaw(string $key, string $value): self
    {
        $this->dataRaw[$key] = $value;
        return $this;
    }

    private function getCurlCommand(): string
    {
        $curl = [
            "curl",
        ];
        foreach ($this->flags as $flag)
            $curl[] = "-$flag";

        $curl[] = "--location \"$this->location\"";
        foreach ($this->headers as $header => $value)
            $curl[] = "--header \"$header: $value\"";

        $jsonPayload = json_encode($this->dataRaw, JSON_UNESCAPED_UNICODE);
        $curl[] = "--data-raw \'$jsonPayload\'";
        $curlCmd = implode(" ", $curl);
        return $curlCmd;
    }

    public function execAsync(): self
    {
        $curlCmd = $this->getCurlCommand();
        $this->lastCommand = "nohup $curlCmd > /dev/null 2>&1 &";
        if (is_dir($this->logPath)) {
            $logPath = $this->logPath;
            $logPath = "$logPath/curl-async-".date("Ymd").".log";
            $this->lastCommand = "nohup $curlCmd >> $logPath 2>&1 &";
        }
        exec($this->lastCommand);
        return $this;
    }

    public function setLogPath(string $logPath): self
    {
        $this->logPath = $logPath;
        return $this;
    }

    public function getLastCommand(): string
    {
        return $this->lastCommand;
    }

    public function printCurl(): self
    {
        echo $this->lastCommand;
        return $this;
    }

    public function reset(): self
    {
        $this->location = "";
        $this->logPath = "";
        $this->flags = [];
        $this->headers = [];
        $this->dataRaw = [];
        $this->lastCommand = "";
        return $this;
    }
}