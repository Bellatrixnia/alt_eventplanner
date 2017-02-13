<?php
/**
 * Created by PhpStorm.
 * User: janakienast
 * Date: 15.12.16
 * Time: 14:50
 */

namespace ALT\AltEventplanner\Tests\Service;

use ALT\AltEventplanner\Service\CreateEventService;

require_once __DIR__ . '/../../Classes/Service/CreateEventService.php';

/**
 * Class CreateEventServiceTest
 *
 * @package ALT\AltEventplanner\Tests\Service
 */
class CreateEventServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CreateEventService
     */
    private $createEventService;

    public function setUp()
    {
        $this->createEventService = new CreateEventService();
    }

    /**
     * @test
     */
    public function testRecurringDatesWeekly()
    {
        $dateTimeStart = new \DateTime('2016/07/01T18:00:00');
        $dateTimeEnd = new \DateTime('2016/07/01T22:00:00');
        $dateTimeFinish = new \DateTime('2016/07/20');
        $recurrenceDays = 'weekly';

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        self::assertEquals(
            [
                [
                    'start' => new \DateTime('2016/07/01T18:00:00'),
                    'end' => new \DateTime('2016/07/01T22:00:00')
                ],
                [
                    'start' => new \DateTime('2016/07/08T18:00:00'),
                    'end' => new \DateTime('2016/07/08T22:00:00')
                ],
                [
                    'start' => new \DateTime('2016/07/15T18:00:00'),
                    'end' => new \DateTime('2016/07/15T22:00:00')
                ]
            ],
            $result
        );
    }

    /**
     * @test
     */
    public function testRecurringDatesBiweekly()
    {
        $eventStart = new \DateTime('2016/12/21T09:00:00');
        $eventEnd = new \DateTime('2016/12/21T16:30:00');
        $eventFinish = new \DateTime('2017/02/02');
        $repetition = "bi-weekly";

        $result = $this->createEventService->getDates($eventStart, $eventEnd, $eventFinish, $repetition);

        self::assertEquals(
            [
                [
                    'start' => new \DateTime('2016/12/21T09:00:00'),
                    'end' => new \DateTime('2016/12/21T16:30')
                ],
                [
                    'start' => new \DateTime('2017/01/04T09:00:00'),
                    'end' => new \DateTime('2017/01/04T16:30:00')
                ],
                [
                    'start' => new \DateTime('2017/01/18T09:00:00'),
                    'end' => new \DateTime('2017/01/18T16:30:00')
                ],
                [
                    'start' => new \DateTime('2017/02/01T09:00:00'),
                    'end' => new \DateTime('2017/02/01T16:30:00')
                ]
            ],
            $result
        );
    }

    /**
     * @test
     */
    public function testRecurringDatesMonthly()
    {
        $dateTimeStart = new \DateTime('2016/01/28T17:00:00');
        $dateTimeEnd = new \DateTime('2016/01/28T20:00:00');
        $dateTimeFinish = new \DateTime('2016/04/30');
        $recurrenceDays = "monthly";

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        self::assertEquals(
            [
                [
                    'start' => new \DateTime('2016/01/28T17:00:00'),
                    'end' => new \DateTime('2016/01/28T20:00:00')
                ],
                [
                    'start' => new \DateTime('2016/02/28T17:00:00'),
                    'end' => new \DateTime('2016/02/28T20:00:00')
                ],
                [
                    'start' => new \DateTime('2016/03/28T17:00:00'),
                    'end' => new \DateTime('2016/03/28T20:00:00')
                ],
                [
                    'start' => new \DateTime('2016/04/28T17:00:00'),
                    'end' => new \DateTime('2016/04/28T20:00:00')
                ]
            ],
            $result
        );
    }

    /**
     * @test
     */
    public function testRecurringDatesInvalidDate()
    {
        $dateTimeStart = new \DateTime('2016/07/12T17:00:00');
        $dateTimeEnd = new \DateTime('2016/07/12T20:00:00');
        $dateTimeFinish = new \DateTime('2016/08/13');
        $recurrenceDays = "monthly";

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        self::assertEquals(
            [
                [
                    'start' => new \DateTime('2016/07/12T17:00:00'),
                    'end' => new \DateTime('2016/07/12T20:00:00')
                ],
                [
                    'start' => new \DateTime('2016/08/12T17:00:00'),
                    'end' => new \DateTime('2016/08/12T20:00:00')
                ]
            ],
            $result
        );
    }

    /**
     * @test
     */
    public function testRecurringDatesBiggerStartDateThanFinishDate()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1482222208);

        $dateTimeStart = new \DateTime('2016/08/12T17:00:00');
        $dateTimeEnd = new \DateTime('2016/08/12T14:00:00');
        $dateTimeFinish = new \DateTime('2016/08/13');
        $recurrenceDays = "monthly";

        $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);
    }

    /**
     * @test
     */
    public function testRecurringDatesBiggerFinishDateThanEndDate()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1482218218);

        $dateTimeStart = new \DateTime('2016/08/12T17:00:00');
        $dateTimeEnd = new \DateTime('2016/08/15T14:00:00');
        $dateTimeFinish = new \DateTime('2016/08/14T02:00:00');
        $recurrenceDays = "monthly";

        $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);
    }

    /**
     * @test
     */
    public function testRecurringDatesMoreThenOneYears()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1487006135);

        $dateTimeStart = new \DateTime('2014/08/12T17:00:00');
        $dateTimeEnd = new \DateTime('2014/08/12T20:00:00');
        $dateTimeFinish = new \DateTime('2015/08/14');
        $recurrenceDays = "monthly";

        $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);
    }

    /**
     * @test
     */
    public function testInvalidStartDateNullGiven()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1482159655);

        $startTime = null;
        $endTime = null;
        $finishTime = null;
        $this->createEventService->getDates($startTime, $endTime, $finishTime, "weekly");
    }

    /**
     * @test
     */
    public function testInvalidEndDateNullGiven()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1482159673);

        $startTime = new \DateTime('2014/08/12T08:00:00');
        $endTime = null;
        $finishTime = null;
        $this->createEventService->getDates($startTime, $endTime, $finishTime, "weekly");
    }

    /**
     * @test
     */
    public function testInvalidFinishDateNullGiven()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1482159680);

        $startTime = new \DateTime('2014/08/12T08:00:00');
        $endTime = new \DateTime('2014/08/13T18:00:00');
        $finishTime = null;
        $this->createEventService->getDates($startTime, $endTime, $finishTime, "weekly");
    }

    /**
     * @test
     */
    public function testInvalidRecurrenceDaysNullGiven()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1482242201);

        $startTime = new \DateTime('2014/08/12T08:00:00');
        $endTime = new \DateTime('2014/08/13T18:00:00');
        $finishTime = new \DateTime('2014/08/13');
        $this->createEventService->getDates($startTime, $endTime, $finishTime, null);
    }

    /**
     * @test
     */
    public function testRecurringDatesFinishDateAfterEndDate()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1482218218);

        $dateTimeStart = new \DateTime('2016/07/12T17:00:00');
        $dateTimeEnd = new \DateTime('2016/07/12T20:00:00');
        $dateTimeFinish = new \DateTime('2016/07/11');
        $recurrenceDays = "monthly";

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        self::assertEquals(
            [
                'start' => new \DateTime('2016/07/12T17:00:00'),
                'end' => new \DateTime('2016/07/12T20:00:00')
            ],
            $result[0]
        );
    }

    /**
     * @test
     */
    public function testRecurringDatesEndDateAfterStartDate()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1482222208);

        $dateTimeStart = new \DateTime('2016/07/13T17:00:00');
        $dateTimeEnd = new \DateTime('2016/07/12T20:00:00');
        $dateTimeFinish = new \DateTime('2016/08/13');
        $recurrenceDays = "monthly";

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        self::assertEquals(
            [
                [
                    'start' => new \DateTime('2016/07/13T17:00:00'),
                    'end' => new \DateTime('2016/07/12320:00:00')
                ],
                [
                    'start' => new \DateTime('2016/08/13T17:00:00'),
                    'end' => new \DateTime('2016/08/13T20:00:00')
                ]
            ],
            $result
        );
    }

    /**
     * @test
     */
    public function testDifferenceBetweenEventStartAndEvenEnd()
    {
        $eventStart = new \DateTime('2016/08/13T17:00:00');
        $eventEnd = new \DateTime('2016/08/13T18:00:00');

        $expected = new \DateInterval('P0DT1H');

        $actual = $this->createEventService->getEventLength($eventStart, $eventEnd);
        self::assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testEventLengthExpectation()
    {
        $eventStart = new \DateTime('2016/08/13T17:00:00');
        $eventEnd = new \DateTime('2016/08/13T17:00:00');

        $expected = new \DateInterval('P0DT0S');

        $actual = $this->createEventService->getEventLength($eventStart, $eventEnd);
        self::assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testEventRepetitionWithEventLength()
    {
        $dateTimeStart = new \DateTime('2016/08/07T09:00:00');
        $dateTimeEnd = new \DateTime('2016/08/10T17:00:00');
        // Changed to "finish", we're checking the date of the last event in combination with the recurrence
        $dateTimeFinish = new \DateTime('2016/08/22');
        $recurrenceDays = 'weekly';

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        self::assertEquals(
            [
                [
                    'start' => new \DateTime('2016/08/07T09:00:00'),
                    'end' => new \DateTime('2016/08/10T17:00:00')
                ],
                [
                    'start' => new \DateTime('2016/08/14T09:00:00'),
                    'end' => new \DateTime('2016/08/17T17:00:00')
                ],
                [
                    'start' => new \DateTime('2016/08/21T09:00:00'),
                    'end' => new \DateTime('2016/08/24T17:00:00')
                ]
            ],
            $result
        );
    }

    /**
     * @test
     */
    public function testGetEndDateFromStartDateAndEventLength()
    {
        $startDate = new \DateTime('2016/07/01T09:00:00');
        $eventLength = new \DateInterval('P0DT2H');

        $expected = new \DateTime('2016/07/01T11:00:00');

        $actual = $this->createEventService->getEventEnd($startDate, $eventLength);

        self::assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testCorrectValueInRecurrenceDaysForWeekly()
    {
        $eventStart = new \DateTime('2016/12/21T09:00:00');
        $eventEnd = new \DateTime('2016/12/21T16:30:00');
        $eventFinish = new \DateTime('2016/12/31');
        $repetition = "weekly";

        $result = $this->createEventService->getDates($eventStart, $eventEnd, $eventFinish, $repetition);

        self::assertEquals(
            [
                [
                    'start' => new \DateTime('2016/12/21T09:00:00'),
                    'end' => new \DateTime('2016/12/21T16:30')
                ],
                [
                    'start' => new \DateTime('2016/12/28T09:00:00'),
                    'end' => new \DateTime('2016/12/28T16:30:00')
                ]
            ],
            $result
        );
    }

    /**
     * @test
     */
    public function testCorrectValueInRecurrenceDaysForBiWeekly()
    {
    }

    /**
     * @test
     */
    public function testCorrectValueInRecurrenceDaysForMonthly()
    {
    }

    /**
     * @test
     */
    public function testRecurrenceDaysForIncorrectValues()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1482242201);

        $eventBegin = new \DateTime('2016/12/20T15:00:00');
        $eventEnd = new \DateTime('2016/12/20T16:30:00');
        $eventFinish = new \DateTime('2016/12/31T23:59:00');
        $recurrenceDays = "bla";

        $this->createEventService->getDates($eventBegin, $eventEnd, $eventFinish, $recurrenceDays);
    }
}
