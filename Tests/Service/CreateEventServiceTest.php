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

    public function testRecurringDatesWeekly()
    {
        $dateTimeStart = new \DateTime('2016/07/01T18:00:00');
        $dateTimeEnd = new \DateTime('2016/07/01T22:00:00');
        // Changed to "finish", we're checking the date of the last event in combination with the recurrence
        $dateTimeFinish = new \DateTime('2016/07/20');
        $recurrenceDays = 'weekly';

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        self::assertEquals(
            [
                'start' => new \DateTime('2016/07/01T18:00:00'),
                'end' => new \DateTime('2016/07/01T22:00:00')
            ],
            $result[0]
        );
        self::assertEquals(
            [
                'start' => new \DateTime('2016/07/08T18:00:00'),
                'end' => new \DateTime('2016/07/08T22:00:00')
            ],
            $result[1]
        );
        self::assertEquals(
            [
                'start' => new \DateTime('2016/07/15T18:00:00'),
                'end' => new \DateTime('2016/07/15T22:00:00')
            ],
            $result[2]
        );
    }

    public function testRecurringDatesBiweekly()
    {
        $dateTimeStart = new \DateTime('2016/07/01T18:00:00');
        $dateTimeEnd = new \DateTime('2016/07/01T22:00:00');
        $dateTimeFinish = new \DateTime('2016/07/20');
        $recurrenceDays = 'bi-weekly';

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        self::assertEquals(
            [
                'start' => new \DateTime('2016/07/01T18:00:00'),
                'end' => new \DateTime('2016/07/01T22:00:00')
            ],
            $result[0]
        );
        self::assertEquals(
            [
                'start' => new \DateTime('2016/07/15T18:00:00'),
                'end' => new \DateTime('2016/07/15T22:00:00')
            ],
            $result[1]
        );
    }

    public function testRecurringDatesMonthly()
    {
        $dateTimeStart = new \DateTime('2016/01/28T17:00:00');
        $dateTimeEnd = new \DateTime('2016/01/28T20:00:00');
        $dateTimeFinish = new \DateTime('2016/04/30');
        $recurrenceDays = "monthly";

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        self::assertEquals(
            [
                'start' => new \DateTime('2016/01/28T17:00:00'),
                'end' => new \DateTime('2016/01/28T20:00:00')
            ],
            $result[0]
        );
        self::assertEquals(
            [
                'start' => new \DateTime('2016/02/28T17:00:00'),
                'end' => new \DateTime('2016/02/28T20:00:00')
            ],
            $result[1]
        );
        self::assertEquals(
            [
                'start' => new \DateTime('2016/03/28T17:00:00'),
                'end' => new \DateTime('2016/03/28T20:00:00')
            ],
            $result[2]
        );
        self::assertEquals(
            [
                'start' => new \DateTime('2016/04/28T17:00:00'),
                'end' => new \DateTime('2016/04/28T20:00:00')
            ],
            $result[3]
        );
    }

    public function testRecurringDatesInvalidDate()
    {
        $dateTimeStart = new \DateTime('2016/07/12T17:00:00');
        $dateTimeEnd = new \DateTime('2016/07/12T20:00:00');
        $dateTimeFinish = new \DateTime('2016/08/13');
        $recurrenceDays = "monthly";

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        if ($dateTimeStart) {
            if ($dateTimeFinish) {
                self::assertEquals(
                    [
                        'start' => new \DateTime('2016/07/12T17:00:00'),
                        'end' => new \DateTime('2016/07/12T20:00:00')
                    ],
                    $result[0]
                );
                self::assertEquals(
                    [
                        'start' => new \DateTime('2016/08/12T17:00:00'),
                        'end' => new \DateTime('2016/08/12T20:00:00')
                    ],
                    $result[1]
                );
            } else {
                throw new \InvalidArgumentException("Die Eingabe muss ein gültiges Datum sein.");
            }
        } else {
            throw new \InvalidArgumentException("Die Eingabe muss ein gültiges Datum sein.");
        }
    }

    public function testRecurringDatesEqualDate()
    {
        $dateTimeStart = new \DateTime('2016/08/11T17:00:00');
        $dateTimeEnd = new \DateTime('2016/08/11T20:00:00');
        $dateTimeFinish = new \DateTime('2016/08/12');
        $recurrenceDays = "monthly";

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        if ($dateTimeStart == $dateTimeFinish) {
            throw new \InvalidArgumentException("Die eingegebenen Termine dürfen nicht identisch sein.");
        } else {
            self::assertEquals(
                [
                    'start' => new \DateTime('2016/08/11T17:00:00'),
                    'end' => new \DateTime('2016/08/11T20:00:00')
                ],
                $result[0]
            );
        }
    }

    public function testRecurringDatesBiggerStartDateThenFinishDate()
    {
        $dateTimeStart = new \DateTime('2016/08/12T17:00:00');
        $dateTimeEnd = new \DateTime('2016/08/12T20:00:00');
        $dateTimeFinish = new \DateTime('2016/08/13');
        $recurrenceDays = "monthly";

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        if ($dateTimeStart >= $dateTimeFinish) {
            throw new \InvalidArgumentException("Die Start des Termins muss vor dem Ende des Termin liegen.");
        } else {
            self::assertEquals(
                [
                    'start' => new \DateTime('2016/08/12T17:00:00'),
                    'end' => new \DateTime('2016/08/12T20:00:00')
                ],
                $result[0]
            );

        }
    }

    public function testRecurringDatesMoreThenOneYears()
    {
        $dateTimeStart = new \DateTime('2014/08/12T17:00:00');
        $dateTimeEnd = new \DateTime('2014/08/12T20:00:00');
        $dateTimeFinish = new \DateTime('2015/08/13');
        $recurrenceDays = "monthly";

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        $countOfResult = count($result);

        if ($countOfResult > 13) {
            throw new \Exception("Der Termin darf nicht häufiger wiederholt werden, als bis zu 1 Jahren in der Zukunft.");
        } else {
            self::assertEquals(
                [
                    'start' => new \DateTime('2014/08/12T17:00:00'),
                    'end' => new \DateTime('2014/08/12T20:00:00')
                ],
                $result[0]
            );
            self::assertEquals(
                [
                    'start' => new \DateTime('2014/09/12T17:00:00'),
                    'end' => new \DateTime('2014/09/12T20:00:00')
                ],
                $result[1]
            );
            self::assertEquals(
                [
                    'start' => new \DateTime('2014/10/12T17:00:00'),
                    'end' => new \DateTime('2014/10/12T20:00:00')
                ],
                $result[2]
            );
            self::assertEquals(
                [
                    'start' => new \DateTime('2014/11/12T17:00:00'),
                    'end' => new \DateTime('2014/11/12T20:00:00')
                ],
                $result[3]
            );
            self::assertEquals(
                [
                    'start' => new \DateTime('2014/12/12T17:00:00'),
                    'end' => new \DateTime('2014/12/12T20:00:00')
                ],
                $result[4]
            );
            self::assertEquals(
                [
                    'start' => new \DateTime('2015/01/12T17:00:00'),
                    'end' => new \DateTime('2015/01/12T20:00:00')
                ],
                $result[5]
            );
            self::assertEquals(
                [
                    'start' => new \DateTime('2015/02/12T17:00:00'),
                    'end' => new \DateTime('2015/02/12T20:00:00')
                ],
                $result[6]
            );
            self::assertEquals(
                [
                    'start' => new \DateTime('2015/03/12T17:00:00'),
                    'end' => new \DateTime('2015/03/12T20:00:00')
                ],
                $result[7]
            );
            self::assertEquals(
                [
                    'start' => new \DateTime('2015/04/12T17:00:00'),
                    'end' => new \DateTime('2015/04/12T20:00:00')
                ],
                $result[8]
            );
            self::assertEquals(
                [
                    'start' => new \DateTime('2015/05/12T17:00:00'),
                    'end' => new \DateTime('2015/05/12T20:00:00')
                ],
                $result[9]
            );
            self::assertEquals(
                [
                    'start' => new \DateTime('2015/06/12T17:00:00'),
                    'end' => new \DateTime('2015/06/12T20:00:00')
                ],
                $result[10]
            );
            self::assertEquals(
                [
                    'start' => new \DateTime('2015/07/12T17:00:00'),
                    'end' => new \DateTime('2015/07/12T20:00:00')
                ],
                $result[11]
            );
            self::assertEquals(
                [
                    'start' => new \DateTime('2015/08/12T17:00:00'),
                    'end' => new \DateTime('2015/08/12T20:00:00')
                ],
                $result[12]
            );
        }
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 1482159655
     */
    public function testInvalidStartDateNullGiven()
    {
        $startTime = null;
        $endTime = null;
        $finishTime = null;
        $this->createEventService->getDates($startTime, $endTime, $finishTime, null);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 1482159673
     */
    public function testInvalidEndDateNullGiven()
    {
        $startTime = new \DateTime('2014/08/12T08:00:00');
        $endTime = null;
        $finishTime = null;
        $this->createEventService->getDates($startTime, $endTime, $finishTime, null);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 1482159680
     */
    public function testInvalidFinishDateNullGiven()
    {
        $startTime = new \DateTime('2014/08/12T08:00:00');
        $endTime = new \DateTime('2014/08/13T18:00:00');
        $finishTime = null;
        $this->createEventService->getDates($startTime, $endTime, $finishTime, null);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 1482161667
     */
    public function testInvalidRecurrenceDaysNullGiven()
    {
        $startTime = new \DateTime('2014/08/12T08:00:00');
        $endTime = new \DateTime('2014/08/13T18:00:00');
        $finishTime = new \DateTime('2014/08/13');
        $this->createEventService->getDates($startTime, $endTime, $finishTime, null);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 1482218218
     */
    public function testRecurringDatesFinishDateAfterEndDate() {
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
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 1482222208
     */
    public function testRecurringDatesEndDateAfterStartDate() {
        $dateTimeStart = new \DateTime('2016/07/13T17:00:00');
        $dateTimeEnd = new \DateTime('2016/07/12T20:00:00');
        $dateTimeFinish = new \DateTime('2016/08/13');
        $recurrenceDays = "monthly";

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        self::assertEquals(
            [
                'start' => new \DateTime('2016/07/13T17:00:00'),
                'end' => new \DateTime('2016/07/12320:00:00')
            ],
            $result[0]
        );
        self::assertEquals(
            [
                'start' => new \DateTime('2016/08/13T17:00:00'),
                'end' => new \DateTime('2016/08/13T20:00:00')
            ],
            $result[1]
        );
    }

    public function testDifferenceBetweenEventStartAndEvenEnd()
    {
        $eventStart = new \DateTime('2016/08/13T17:00:00');
        $eventEnd = new \DateTime('2016/08/13T18:00:00');

        $expected = new \DateInterval('P0DT1H');

        $actual = $this->createEventService->getEventLength($eventStart, $eventEnd);
        self::assertEquals($expected, $actual);
    }

    public function testEventLengthExceptions()
    {
        $eventStart = new \DateTime('2016/08/13T17:00:00');
        $eventEnd = new \DateTime('2016/08/13T17:00:00');

        $expected = new \DateInterval('P0DT0S');

        $actual = $this->createEventService->getEventLength($eventStart, $eventEnd);
        self::assertEquals($expected, $actual);
    }

    public function testEventRepertitionWithEventLength()
    {
        $dateTimeStart = new \DateTime('2016/08/07T09:00:00');
        $dateTimeEnd = new \DateTime('2016/08/10T17:00:00');
        // Changed to "finish", we're checking the date of the last event in combination with the recurrence
        $dateTimeFinish = new \DateTime('2016/08/22');
        $recurrenceDays = 'weekly';

        $result = $this->createEventService->getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays);

        self::assertEquals(
            [
                'start' => new \DateTime('2016/08/07T09:00:00'),
                'end' => new \DateTime('2016/08/10T17:00:00')
            ],
            $result[0]
        );
        self::assertEquals(
            [
                'start' => new \DateTime('2016/08/14T09:00:00'),
                'end' => new \DateTime('2016/08/17T17:00:00')
            ],
            $result[1]
        );
        self::assertEquals(
            [
                'start' => new \DateTime('2016/08/21T09:00:00'),
                'end' => new \DateTime('2016/08/24T17:00:00')
            ],
            $result[2]
        );

    }
}