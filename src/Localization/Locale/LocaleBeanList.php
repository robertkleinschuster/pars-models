<?php

namespace Pars\Model\Localization\Locale;

use Pars\Bean\Type\Base\AbstractBaseBeanList;

/**
 * Class LocaleBeanList
 * @package Pars\Model\Localization\Locale
 */
class LocaleBeanList extends AbstractBaseBeanList
{
    /**
     * @return array
     */
    public function getSelectOptions(): array
    {
        return $this->column('Locale_Name', 'Locale_Code');
    }
}
