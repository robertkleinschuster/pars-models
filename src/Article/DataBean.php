<?php


namespace Pars\Model\Article;


use Niceshops\Bean\Type\Base\AbstractBaseBean;

class DataBean extends AbstractBaseBean
{
    public ?bool $vote_once = false;
    public ?string $contact_email = '';
    public ?string $User_Displayname_Create = null;
    public ?string $User_Displayname_Edit = null;
}
