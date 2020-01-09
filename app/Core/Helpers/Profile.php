<?php

namespace App\Core\Helpers;

class Profile
{
    /**
     * return the percentage of profile
     *
     * Create account - 0%
     * Activate account - 20%
     * Provide profile information - 40%
     * What jobs are you interested in? - 50%
     * Do you have relevant experience in these jobs? - 70%
     * Are you a freelancer? - 90%
     * Waiting for approval - 99%
     * Approval - 100%
     *
     * @return array
     *
     * @author Ahmed Amasha <ahmed.amasha@tajawal.com>
     *
     */
    public function profilePercentage(): array
    {
        return [0, 20, 40, 50, 70, 90, 99, 100];
    }
}
