<?php

namespace spec\OfficeInvitation;

use OfficeInvitation\Customer;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Customer
 */
class CustomerSpec extends ObjectBehavior
{
    function it_calculates_distance()
    {
        $this->beConstructedWith(
            1,
            'some name',
            1111,
            -1111
        );

        $this->getDistanceInKmTo(53.339428, -6.257664)->shouldBe(3180);
    }
}
