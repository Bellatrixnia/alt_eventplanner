<?php
namespace ALT\AltEventplanner\Service;
class Calendar
{

    /**
     * @param int $year
     * @param int $month
     *
     * @return string
     */
    public function renderMonth(int $year = 2016, int $month = 1)
    {
        $content = [];
        $daysInMonth = (int)date('t', mktime(0, 0, 0, $month, 1, $year));
        $day = 1;
        $content['month'] = date('F', mktime(0, 0, 0, $month, $day, $year));
        while ($day <= $daysInMonth) {
            $addCss = '';
            $dateIdent = $year.$month.$day;
            if (date('N', mktime(0, 0, 0, $month, $day, $year)) > 5) {
                $addCss = ' weekend';
            }

            $content['days'][$dateIdent] = [
                'day' => date('d, D', mktime(0, 0, 0, $month, $day, $year)),
                'cssInfo' => $addCss,
            ];
            $day++;
        }
        return $content;
    }

    /**
     * Gets the current Month of the current year
     *
     * @return array
     */
    public function getCurrentYearAndMonth()
    {
        return [
            'year' => (int)date('Y'),
            'month' => (int)date('m')
        ];
    }

    public function getNextMonth($year, $month)
    {
        if ((int)$month + 1 === 13) {
            $year = (int)$year + 1;
            $month = 1;
        } else {
            $month = (int)$month + 1;
        }
        return [
            'year' => (int)$year,
            'month' => $month
        ];
    }

    public function getPreviousMonth($year, $month)
    {
        $currentMonthAndYear = $this->getCurrentYearAndMonth();
        $yearSwitch = false;

        if ((int)$month - 1 === 0) {
            $year = (int)$year - 1;
            $month = 12;
            $yearSwitch = true;
        } else {
            $month = (int)$month - 1;
        }

        /**
         * This needs test coverage
         * for the time being we limit to 2015
         */
        if($year === 2015) {
            $year = null;
            $month = null;
        }
//        if (
//            ($yearSwitch && $year < $currentMonthAndYear['year'])
//            ||
//            (!$yearSwitch && $month < $currentMonthAndYear['month'])
//        ) {
//            $year = null;
//            $month = null;
//        }

        return [
            'year' => (int)$year,
            'month' => $month
        ];
    }
}