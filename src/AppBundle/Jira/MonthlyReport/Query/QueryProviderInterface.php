<?php

namespace AppBundle\Jira\MonthlyReport\Query;

interface QueryProviderInterface
{
    public function getQuery(): string;
}
