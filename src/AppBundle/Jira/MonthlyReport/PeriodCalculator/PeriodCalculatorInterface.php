<?php

namespace AppBundle\Jira\MonthlyReport\PeriodCalculator;

use League\Period\Period;

interface PeriodCalculatorInterface
{
    public function calculate(): Period;
}
