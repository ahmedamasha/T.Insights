<?php
namespace App\Core\Helpers;

class Csv
{
    private   $filename;
    protected $rows = [];

    public function __construct($filename = "file")
    {
        $this->filename = $filename . '.csv';
    }

    /**
     * readCSV
     *
     * @param $file
     *
     * @return array
     *
     * @author Ahmed Amasha <ahmed.amasha@tajawal.com>
     *
     */
    public function readCSV($file)
    {
        if (($handle = fopen($file, "r")) !== false) {

            $result = [];

            $header_string = fgetcsv($handle); //Removes the first line of headings in the csv

            $header_array = explode(';', $header_string[0]);

            while ($data = fgetcsv($handle)) {
                $row = explode(';', $data[0]);

                $data = [
                    $header_array[0] => (int)$row[0],
                    $header_array[1] => $row[1],
                    $header_array[2] => (int)$row[2],
                    $header_array[3] => (int)$row[3],
                    $header_array[4] => (int)$row[4],
                ];

                $result[] = $data;
            }

            return $result;

        }
        fclose($handle);
    }
}

?>
