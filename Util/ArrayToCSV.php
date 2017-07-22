<?php
/**
 * Created by PhpStorm.
 * User: iknsa
 * Date: 22/07/17
 * Time: 22:00
 */

namespace IKNSA\HelperBundle\Util;


class ArrayToCSV
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var bool
     */
    private $hasHeader;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var string
     */
    private $enclosure;

    /**
     * @var string
     */
    private $escape_char;

    private $header = [];

    /**
     * ArrayToCSV constructor.
     *
     * If $hasHeader is bool and true, $data keys will be used as header. Else no header will be set
     *
     * @param bool|array $hasHeader default true
     * @param string $delimiter One char default ','
     * @param string $enclosure One char default '"'
     * @param string $escape_char One char '\"
     */
    public function __construct($hasHeader = true, $delimiter = ',', $enclosure = '"', $escape_char = '\\')
    {
        $this->hasHeader = $hasHeader;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escape_char = $escape_char;
    }

    /**
     * $data = array(["username" => "Khalid", "github" => "khalid-s"], ["username" => "Sookia", "github" => "khalid-s"])
     * $out = username;github;
     *        Khalid;khalid-s
     *        Sookia;khalid-s
     *
     * @todo refactor by adding the header after the csv has been written to run the foreach once only
     *
     * @param array $data
     *
     * @return string $csv
     */
    public function makeCSV(array $data = [])
    {
        $this->data = $data;

        ob_start();
        $out = fopen('php://output', 'w');

        $values = [];
        foreach ($this->data as $data) {
            $values[] = $this->getValues($data);
        }

        array_unshift($values, $this->header);

        foreach ($values as $value) {
            fputcsv($out, $value, $this->delimiter, $this->enclosure, $this->escape_char);
        }

        $content = ob_get_contents();
        ob_end_clean();

        fclose($out);

        return $content;
    }

    /**
     * Sets the header and the values in an indexed array
     *
     * @param array $data
     *
     * @return array
     */
    private function getValues(array $data)
    {
        $values = [];
        foreach ($data as $key => $value) {
            if (!in_array($key, $this->header)) $this->header[] = $key;

            $values[] = $value;
        }

        return $values;
    }
}
