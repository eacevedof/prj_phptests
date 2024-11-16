<?php
namespace Misc\Shell;

final class Curl
{
    private string $logPath = "";
    private string $location = "";
    private array $flags = [];
    private array $headers = [];
    private array $commands = [];
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
        $this->url = $url;
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

        $curl[] = "--location \"$this->url\"";
        foreach ($this->headers as $header => $value)
            $curl[] = "--header \"$header: $value\"";

        $jsonPayload = json_encode($this->dataRaw, JSON_UNESCAPED_UNICODE);
        $curl[] = "--data-raw \'$jsonPayload\'";
        $curlCmd = implode(" ", $curl);
        return $curlCmd;
    }

    public function execAsync(): void
    {
        $curlCmd = $this->getCurlCommand();
        $logPath = $this->logPath;
        $logPath = "$logPath/curl-async-".date("Ymd").".log";

        $this->lastCommand = "nohup $curlCmd >> $logPath 2>&1 &";
        echo $this->lastCommand;
        exec($this->lastCommand);
    }

    public function setLogPath(string $logPath): self
    {
        $this->logPath = $logPath;
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