<?php

namespace Tests\Unit;

use App\Core\Helpers\Profile;
use App\Core\Request\InsightsRequest;
use App\Helpers\Csv;
use PHPUnit\Framework\TestCase;

class InsightsTest extends TestCase
{
    /**
     * testProfile
     *
     * @author Ahmed Amasha <ahmed.amasha@tajawal.com>
     *
     */
    public function testCsv()
    {
        $csv = new Csv("onboarding ");

        $cs = $csv->readCSV("resources/assets/export.csv");
        $this->assertContains("user_id", $cs[0]);
        $this->assertContains("created_at", $cs[0]);
        $this->assertContains("onboarding_perentage", $cs[0]);
        $this->assertContains("count_applications", $cs[0]);
    }

    public function testGetGroupedData()
    {
        $insight    = app(InsightsRequest::class);
        $input      = [[
                           "user_id"                     => 3121,
                           "created_at"                  => "2016-07-19",
                           "onboarding_perentage"        => 40,
                           "count_applications"          => 0,
                           "count_accepted_applications" => 0,
                       ],
                       [
                           "user_id"                     => 3122,
                           "created_at"                  => "2016-07-19",
                           "onboarding_perentage"        => 40,
                           "count_applications"          => 0,
                           "count_accepted_applications" => 0,
                       ]];
        $insightArr = $insight->getGroupedData($input);

        $this->assertEquals(29, key($insightArr));
        $this->assertTrue(is_int(key($insightArr)));

    }
}
