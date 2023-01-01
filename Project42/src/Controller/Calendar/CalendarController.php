<?php

namespace App\Controller\Calendar;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CalendarController extends AbstractController
{
    #[Route('/calendar/{row}/{month}', name: 'calendar_row', requirements: ['row' => 'row'])]
    #[Route('/calendar/{table}/{month}', name: 'calendar_table', requirements: ['table' => 'table'])]
    #[Route('/calendar/{weekend}/{month}', name: 'calendar_weekend', requirements: ['weekend' => 'weekend'])]
    public function calendar(int $month, ?string $table = null, ?string $weekend = null)
    {
        $data = self::CreateMonth($month);

        if ($month < 1 || $month > 12) {
            return $this->render('calendar/invalidmonth.twig');
        }

        switch ($month){
            case 1:
                echo '<h1>Январь</h1>';
                break;
            case 2:
                echo '<h1>Февраль</h1>';
                break;
            case 3:
                echo '<h1>Март</h1>';
                break;
            case 4:
                echo '<h1>Апрель</h1>';
                break;
            case 5:
                echo '<h1>Май</h1>';
                break;
            case 6:
                echo '<h1>Июнь</h1>';
                break;
            case 7:
                echo '<h1>Июль</h1>';
                break;
            case 8:
                echo '<h1>Август</h1>';
                break;
            case 9:
                echo '<h1>Сентябрь</h1>';
                break;
            case 10:
                echo '<h1>Октябрь</h1>';
                break;
            case 11:
                echo '<h1>Ноябрь</h1>';
                break;
            case 12:
                echo '<h1>Декабрь</h1>';
                break;
        }

        $formating = !is_null($table) ? 'base' : (!is_null($weekend) ? 'weekend' : 'row');
        return $this->render("calendar/{$formating}.twig", ['month' => $month, 'calendar' => $data]);
    }

    public static function CreateMonth(int $month): ?array
    {
        $data = [];

        $date = new \Datetime();
        $date->setDate(date('Y'), $month, 1);

        do {
            $data[] = [
                'day' => $date->format('j'),
                'weekday' => $date->format('N'),
                'date' => $date->format('d.m.Y'),
                'weekdayDay' => self::getWeekday($date->format('N')),
                'isWeekend' => self::isWeekend($date->format('N')),
            ];
            $date->add(new \DateInterval('P1D'));
        } while ($date->format('m') == $month);

        return ['items' => $data, 'firstday' => $data[0]['weekday'], 'last' => end($data)['weekday']];
    }

    public static function isWeekend(int $day): bool
    {
        return $day >= 6 && $day <= 7;
    }

    public static function getWeekday(int $day): ?string
    {
        return match ($day) {
            1 => 'Понедельник',
            2 => 'Вторник',
            3 => 'Среда',
            4 => 'Четверг',
            5 => 'Пятница',
            6 => 'Суббота',
            7 => 'Воскресенье',
            default => null
        };
    }
}