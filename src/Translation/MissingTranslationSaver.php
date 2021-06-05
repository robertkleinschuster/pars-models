<?php


namespace Pars\Model\Translation;


use Pars\Core\Database\ParsDatabaseAdapter;
use Pars\Core\Database\ParsDatabaseAdapterAwareTrait;
use Pars\Core\Translation\MissingTranslationSaverInterface;
use Pars\Core\Translation\ParsTranslator;
use Pars\Core\Translation\ParsTranslatorAwareTrait;
use Pars\Model\Translation\TranslationLoader\TranslationBeanFinder;
use Pars\Model\Translation\TranslationLoader\TranslationBeanProcessor;

class MissingTranslationSaver implements MissingTranslationSaverInterface
{
    use ParsDatabaseAdapterAwareTrait;

    /**
     * MissingTranslationSaver constructor.
     */
    public function __construct(ParsDatabaseAdapter $adapter)
    {
        $this->setDatabaseAdapter($adapter);
    }

    public function saveMissingTranslation(string $locale, string $code, string $namespace, string $text = null)
    {
        if ($text === null) {
            $text = $code;
        }
        $translationFinder = new TranslationBeanFinder($this->getDatabaseAdapter());
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
            $translationProcessor = new TranslationBeanProcessor($this->getDatabaseAdapter());
            $translationProcessor->setBeanList($beanList);
            $translationProcessor->save();
        }
    }


}
