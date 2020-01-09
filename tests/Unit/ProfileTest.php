<?php

namespace Tests\Unit;

use App\Core\Helpers\Profile;
use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase
{
    /**
     * DESC
     *
     * @author Ahmed Amasha <ahmed.amasha@tajawal.com>
     *
     */
    public function testProfile()
    {
       $profile = new Profile();
       $data =$profile->profilePercentage();
       $this->assertContains(0, $data);
       $this->assertContains(20, $data);
       $this->assertContains(40, $data);
       $this->assertContains(50, $data);
       $this->assertContains(70, $data);
       $this->assertContains(90, $data);
       $this->assertContains(99, $data);
       $this->assertContains(100, $data);
    }

}
