<?php

namespace App\Core\Request;

use App\Core\Constants\Constants;
use App\Core\Helpers\Csv;
use App\Core\Helpers\Profile;
use Illuminate\Http\Response;

/**
 * Class InsightsController
 *
 * @package App\Http\Controllers
 */
class InsightsRequest extends Request
{
    /**
     * @var \App\Core\Helpers\Profile
     */
    private $profile;

    /**
     * InsightsRequest constructor.
     *
     * @param \App\Core\Helpers\Profile $profile
     */
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }


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

        // calculate the percentage of data per week
        $result = [];
        foreach ($groupedInsights as $k => $groupedInsight) {

            $arrayCount = array_count_values(array_column($groupedInsight, Constants::ONBOARDINGFLAG));

            $data      = $this->spreadAccountData($arrayCount, $groupedInsights[$k]);
            $result [] = [
                Constants::INSIGHTS_NAME_KEY=> "week " . $k,
                Constants::INSIGHTS_DATA_KEY => $data,
            ];
        }

        return response($result);
    }


    public function spreadAccountData($accountData, $groupInsights)
    {
        $insights   = [];
        $AccountArr = $this->profile->profilePercentage();

        $insights[0] = 100; //  starting from 100 on y axis

        // get the data of accounts  per account percentage
        $i = 1;
        foreach ($AccountArr as $item) {
            $insights[$i] = round(($this->checkPercentageExists($item, $accountData) / count($groupInsights)) * 100);
            $i++;
        }

        return array_values($insights);
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
        $csv     = new Csv("on-boarding data for Temper");
        $csvPath = $this->getCsvPath();

        return $csv->readCSV($csvPath);

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

    /**
     * getCsvPath from env file
     *
     * @return string
     *
     * @author Ahmed Amasha <ahmed.amasha@tajawal.com>
     *
     */
    private function getCsvPath(): string
    {
        return resource_path(env("CSVPATH"));
    }
}
