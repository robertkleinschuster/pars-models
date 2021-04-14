<?php


namespace Pars\Model\Task\Log;


use Pars\Bean\Type\Base\AbstractBaseBean;
use Pars\Core\Database\DefaultBeanFieldTrait;

class TaskLogBean extends AbstractBaseBean
{
    use DefaultBeanFieldTrait;
    public ?int $TaskLog_ID = null;
    public ?string $TaskLog_Message = null;
    public ?string $TaskLog_Text = null;
}
