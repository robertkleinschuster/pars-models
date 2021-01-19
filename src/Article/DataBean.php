<?php


namespace Pars\Model\Article;


use Niceshops\Bean\Type\Base\AbstractBaseBean;

class DataBean extends AbstractBaseBean
{
    public ?bool $vote_once = null;
    public ?string $contact_email = '';
    public ?string $author = null;
    public ?string $editor = null;
}
