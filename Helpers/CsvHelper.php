<?php
namespace Helpers;

class CsvHelper
{
    private $csvData;
    private $headers;
    private $filename;

    public function __construct(array $data)
    {
        $this->csvData = $data;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function setFileName($filename)
    {
        $this->filename = (string) $filename;
    }

    public function export()
    {
        if (!$this->filename) {
            throw new \Exception("filename have not been set");
        }

        $fp = fopen($this->filename.".csv", "w");
        if ($this->headers) {
            fputcsv($fp, $this->headers);
        }

        foreach ($this->csvData as $data) {
            fputcsv($fp, $data);
        }

        fclose($fp);
    }
}
