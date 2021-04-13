<?php


namespace Pars\Model\Translation;


use Laminas\Db\Adapter\AdapterAwareInterface;
use Laminas\Db\Adapter\AdapterAwareTrait;
use Laminas\Db\Adapter\AdapterInterface;
use Pars\Core\Translation\MissingTranslationSaverInterface;
use Pars\Model\Translation\TranslationLoader\TranslationBeanFinder;
use Pars\Model\Translation\TranslationLoader\TranslationBeanProcessor;

class MissingTranslationSaver implements MissingTranslationSaverInterface, AdapterAwareInterface
{
    use AdapterAwareTrait;


    /**
     * MissingTranslationSaver constructor.
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->setDbAdapter($adapter);
    }

    public function saveMissingTranslation(string $locale, string $code, string $namespace, string $text = null)
    {
        if ($text === null) {
            $text = $code;
        }
        $translationFinder = new TranslationBeanFinder($this->adapter);
        $translationFinder->filterLocale_Code($locale);
        $translationFinder->filterTranslation_Code($code);
        $translationFinder->filterTranslation_Namespace($namespace);
        if ($translationFinder->count() == 0) {
            $bean = $translationFinder->getBeanFactory()->getEmptyBean([]);
            $bean->set('Translation_Code', $code);
            $bean->set('Locale_Code',$locale);
            $bean->set('Translation_Namespace', $namespace);
            $bean->set('Translation_Text', $text);
            $beanList = $translationFinder->getBeanFactory()->getEmptyBeanList();
            $beanList->push($bean);
            $translationProcessor = new TranslationBeanProcessor($this->adapter);
            $translationProcessor->setBeanList($beanList);
            $translationProcessor->save();
        }
    }


}
