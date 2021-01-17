<?php


namespace Pars\Model\Article;


use Niceshops\Bean\Type\Base\AbstractBaseBean;

class DataBean extends AbstractBaseBean
{
    public ?bool $vote_once = false;
    public ?string $contact_email = '';
}
