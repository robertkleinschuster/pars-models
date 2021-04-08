<?php

namespace Pars\Model\File\Type;

use Pars\Bean\Type\Base\AbstractBaseBeanList;

/**
 * Class FileTypeBeanList
 * @package Pars\Model\File\Type
 */
class FileTypeBeanList extends AbstractBaseBeanList
{
    /**
     * @return array
     */
    public function getSelectOptions(): array
    {
        $options = [];
        foreach ($this as $bean) {
            $options[$bean->get('FileType_Code')] = $bean->get('FileType_Name');
        }
        return $options;
    }
}
