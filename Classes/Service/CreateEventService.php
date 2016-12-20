<?php
/**
 * Created by PhpStorm.
 * User: janakienast
 * Date: 15.12.16
 * Time: 14:49
 */

namespace ALT\AltEventplanner\Service;


use ALT\AltEventplanner\Tests\Service\CreateEventServiceTest;

class CreateEventService
{

    public function getDates($dateTimeStart, $dateTimeEnd, $dateTimeFinish, $recurrenceDays)
    {
        switch ($recurrenceDays) {
            case 'weekly':
                $recurrenceDays = 'P1W';
                break;
            case 'bi-weekly':
                $recurrenceDays = 'P2W';
                break;
            case 'monthly':
                $recurrenceDays = 'P1M';
                break;
        }

        /**
         * Überprüfen ob eingabe für $dateTimeStart, $dateTimeEnd und $dateTimeFinish DateTime-Objekte sind
         */
        switch (false) {
            case $dateTimeStart instanceof \DateTime:
                throw new \InvalidArgumentException("Die Eingabe im Feld 'Startdate' muss ein gültiges Datum sein.", 1482159655);
                break;
            case $dateTimeEnd instanceof \DateTime:
                throw new \InvalidArgumentException("Die Eingabe im Feld 'Enddate' muss ein gültiges Datum sein.", 1482159673);
                break;
            case $dateTimeFinish instanceof \DateTime:
                throw new \InvalidArgumentException("Die Eingabe im Feld 'Finishdate' muss ein gültiges Datum sein.", 1482159680);
                break;
        }

        if (empty($recurrenceDays) || is_null($recurrenceDays)) {
            throw new \InvalidArgumentException("Die Eingabe im Feld 'Repetition' darf nicht 'NULL' oder leer sein.", 1482161667);
        }

        if ($dateTimeFinish < $dateTimeEnd) {
            throw new \InvalidArgumentException("Das 'Finishdate' muss nach dem 'Enddate' liegen.", 1482218218);
        }

        if ($dateTimeEnd < $dateTimeStart) {
            throw new \InvalidArgumentException("Das 'Enddate' muss nach dem 'Startdate' liegen.", 1482222208);
        }


        // Intervall-Objekt generieren (http://php.net/manual/de/class.dateinterval.php)
        // (http://php.net/manual/de/dateinterval.construct.php)
        $dateInterval = new \DateInterval($recurrenceDays);

        // Aufbauen des Datumsbereiches (http://php.net/manual/de/class.dateperiod.php)
        $dateRangeStart = new \DatePeriod($dateTimeStart, $dateInterval, $dateTimeFinish);
        $dateRangeEnd = new \DatePeriod($dateTimeEnd, $dateInterval, $dateTimeFinish);

        $returnValues = [];
        // Alle Daten in ein Array speichern
        $i = 0;
        foreach ($dateRangeStart as $date) {
            $returnValues[$i]['start'] = $date;
            $i++;
        }
        $c = 0;
        foreach ($dateRangeEnd as $item) {
            $returnValues[$c]['end'] = $item;
            $c++;
        }
        return $returnValues;
    }

    /**
     * @param \DateTime $eventBegin Datum und Uhrzeit, an dem ein Event startet
     * @param \DateTime $eventEnd Datum und Uhrzeit, an dem ein Event endet
     * @return \DateInterval
     */
    public function getEventLength(\DateTime $eventBegin, \DateTime $eventEnd)
    {
        $eventLength = $eventBegin->diff($eventEnd);
        return $eventLength;
    }
}