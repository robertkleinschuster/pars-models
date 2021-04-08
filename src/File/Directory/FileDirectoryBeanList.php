<?php

namespace Pars\Model\File\Directory;

use Pars\Bean\Type\Base\AbstractBaseBeanList;

/**
 * Class FileDirectoryBeanList
 * @package Pars\Model\File\Directory
 */
class FileDirectoryBeanList extends AbstractBaseBeanList
{
    /**
     * @return array
     */
    public function getSelectOptions(): array
    {
        $options = [];
        foreach ($this as $bean) {
            $options[$bean->get('FileDirectory_ID')] = $bean->get('FileDirectory_Name');
        }
        return $options;
    }
}
