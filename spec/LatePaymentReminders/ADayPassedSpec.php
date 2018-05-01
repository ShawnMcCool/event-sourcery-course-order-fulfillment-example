<?php namespace spec\OrderFulfillment\LatePaymentReminders;

use OrderFulfillment\LatePaymentReminders\ADayPassed;
use PhpSpec\ObjectBehavior;

class ADayPassedSpec extends ObjectBehavior {

    function let() {
        $this->beConstructedWith(
            new \DateTimeImmutable('2018-05-01')
        );
    }

    function it_is_initializable() {
        $this->shouldHaveType(ADayPassed::class);
        $this->completedDate()->format('Y-m-d')->shouldBe('2018-05-01');
    }

    function it_can_be_serialized() {
        $this->serialize()->shouldReturn([
            'completedDate' => '2018-05-01',
        ]);
    }

    function it_can_be_deserialized() {
        $this->beConstructedThrough('deserialize', [[
            'completedDate' => '2018-05-02',
        ]]);
        $this->completedDate()->format('Y-m-d')->shouldBe('2018-05-02');
    }
}
