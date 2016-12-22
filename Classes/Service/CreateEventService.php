<?php
namespace ALT\AltEventplanner\Service;

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
            default:
                throw new \InvalidArgumentException("Die Auswahl für die Wiederholung im Feld 'Repetition' muss entweder 'weekly', 'bi-weekly' oder 'monthly' sein.", 1482242201);
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


        if ($dateTimeFinish < $dateTimeEnd) {
            throw new \InvalidArgumentException("Das 'Finishdate' muss nach dem 'Enddate' liegen.", 1482218218);
        }

        if ($dateTimeEnd < $dateTimeStart) {
            throw new \InvalidArgumentException("Das 'Enddate' muss nach dem 'Startdate' liegen.", 1482222208);
        }


        // Intervall-Objekt generieren (http://php.net/manual/de/class.dateinterval.php) / (http://php.net/manual/de/dateinterval.construct.php)
        $dateInterval = new \DateInterval($recurrenceDays);

        // Aufbauen des Datumsbereiches (http://php.net/manual/de/class.dateperiod.php)
        $dateRangeStart = new \DatePeriod($dateTimeStart, $dateInterval, $dateTimeFinish);

        $eventLength = $this->getEventLength($dateTimeStart, $dateTimeEnd);

        $returnValues = [];
        // Alle Daten in ein Array speichern
        foreach ($dateRangeStart as $date) {
            $returnValues[] = [
                'start' => $date,
                'end' => $this->getEventEnd($date, $eventLength)
            ];
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

    /**
     * @param \DateTime $eventBegin Uhrzeit und Datum, an dem ein Event beginnt
     * @param \DateInterval $eventLength Zeitspanne zum Ende des Events
     * @return \DateTime
     */
    public function getEventEnd(\DateTime $eventBegin, \DateInterval $eventLength)
    {
        $eventEnd = clone $eventBegin;
        $eventEnd->add($eventLength);
        return $eventEnd;
    }
}