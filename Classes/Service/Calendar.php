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
}