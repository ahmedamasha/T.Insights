<?php

namespace App\Core\Request;

use App\Core\Helpers\Csv;
use DateInterval;
use Illuminate\Http\Response;

/**
 * Class InsightsController
 *
 * @package App\Http\Controllers
 */
class InsightsRequest extends Request
{
    const CSVPATH = "assets/export.csv";

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
        ];
    }

    /**
     * get all attributes
     *
     * @return array
     *
     * @author Ahmed Amasha <ahmed.amasha@tajawal.com>
     *
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * process remove product
     *
     * @author Ahmed Amasha <ahmed.amasha@tajawal.com>
     *
     */
    public function process(): Response
    {

        $insights = $this->getCsvData(); // reading data from csc


        $groupedInsights = $this->getGroupedData($insights); // grouping weekly data

        $result = [];
        foreach ($groupedInsights as $k => $groupedInsight) {

            $arrayCount = array_count_values(array_column($groupedInsight, "onboarding_perentage"));

            $data    = [];
            $data[0] = 100;

            $data[1] = round(($this->checkPercentageExists(0, $arrayCount) / count($groupedInsights[$k])) * 100);
            $data[2] = round(($this->checkPercentageExists(20, $arrayCount) / count($groupedInsights[$k])) * 100);
            $data[3] = round(($this->checkPercentageExists(40, $arrayCount) / count($groupedInsights[$k])) * 100);
            $data[4] = round(($this->checkPercentageExists(50, $arrayCount) / count($groupedInsights[$k])) * 100);
            $data[5] = round(($this->checkPercentageExists(70, $arrayCount) / count($groupedInsights[$k])) * 100);
            $data[6] = round(($this->checkPercentageExists(90, $arrayCount) / count($groupedInsights[$k])) * 100);
            $data[7] = round(($this->checkPercentageExists(99, $arrayCount) / count($groupedInsights[$k])) * 100);
            $data[8] = round(($this->checkPercentageExists(100, $arrayCount) / count($groupedInsights[$k])) * 100);

            $result [] = [
                "name" => "week " . $k,
                "data" => $data,
            ];
        }

        return response($result);
    }

    /**
     * checkPercentageExists
     *
     * @param $key
     * @param $item
     *
     * @return int
     *
     * @author Ahmed Amasha <ahmed.amasha@tajawal.com>
     *
     */
    private function checkPercentageExists($key, $item)
    {
        if (!array_key_exists($key, $item)) {
            return 0;
        }

        return $item[$key];
    }

    /**
     * read data from the csv
     *
     * @return array
     *
     * @author Ahmed Amasha <ahmed.amasha@tajawal.com>
     *
     */
    private function getCsvData(): array
    {
        //Start the CSV object and provide a filename
        $csv = new Csv("on-boarding data for Temper");

        return $csv->readCSV(resource_path(self::CSVPATH));

    }

    /**
     * getdata grouped per week
     *
     * @param array $insights
     *
     * @return array
     *
     * @author Ahmed Amasha <ahmed.amasha@tajawal.com>
     *
     */
    private function getGroupedData(array $insights): array
    {
        $groupedInsights = [];
        //mapping throw the data ...
        foreach ($insights as $insight) {

            // @see http://us2.php.net/manual/en/function.date.php
            // using ('w') to get date by week
            $week = date('W', strtotime($insight['created_at']));

            // create new empty array if it hasn't been created yet
            if (!isset($groupedInsights[$week])) {
                $groupedInsights[$week] = [];
            }
            //append the post to the array
            $groupedInsights[$week][] = $insight;
        }

        return $groupedInsights ?? [];
    }
}
