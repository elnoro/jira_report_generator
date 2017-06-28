<?php

namespace AppBundle\Jira\MonthlyReport\Pipeline;

use AppBundle\Jira\MonthlyReport\Report\RowList;
use AppBundle\Translation\Direction;
use AppBundle\Translation\TranslatorInterface;

final class TranslateDescriptions
{
    /** @var TranslatorInterface */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function __invoke($payload)
    {
        return $this->translateDescriptions($payload);
    }

    public function translateDescriptions(RowList $reportRows): RowList
    {
        $enRu = new Direction('en', 'ru');
        foreach ($reportRows->getRows() as $row) {
            if ($row->getSuggestedDescription()) {
                continue;
            }

            $translatedDescription = $this->translator->translate([$row->getOriginalDescription()], $enRu)[0] ?? null;
            if ($translatedDescription) {
                $row->suggestDescription($translatedDescription);
            }
        }

        return $reportRows;
    }
}
