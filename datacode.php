<?php

class Translation
{
    /**
     * @var string
     */
    private $translationFile;
    /**
     * @var string
     */
    private $defaultTranslationFile;
    /**
     * @var mixed
     */
    private $translation;
    /**
     * @var mixed
     */
    private $defaultTranslation;

    /**
     * @param $lang
     * @param string $translationDir
     * @param string $defaultLang
     */
    public function __construct($lang, $translationDir = "langs/", $defaultLang = "english")
    {
        $this->translationFile = "{$translationDir}{$lang}.json";
        $this->defaultTranslationFile = "{$translationDir}{$defaultLang}.json";

        $this->loadTranslations();
    }

    /**
     * @param $langKey
     * @return Error|string
     */
    public function getTranslation($langKey)
    {
        //Checks to see if the key is set in the array and returns true if it is set
        if (array_key_exists($langKey, $this->translation)) {
            return $this->translation[$langKey];
        }
        if (array_key_exists($langKey, $this->defaultTranslation)) {
            return $this->defaultTranslation[$langKey];
        }
        //If the key is not found
        throw new Error('No valid translation');
    }
    //Checks to see if the json files are in the path
    private function loadTranslations()
    {
        if (
            !file_exists($this->translationFile) ||
            !file_exists($this->defaultTranslationFile)) {
            throw new Error('File does not exist');
        }
        $this->translation = json_decode(file_get_contents($this->translationFile), true);
        $this->defaultTranslation = json_decode(file_get_contents($this->defaultTranslationFile), true);
    }
}

try {
    $trans = new Translation('pirate');
    print($trans->getTranslation('SUBMIT_BUTTON'));
} catch (Error $ex) {
    print($ex->getMessage());
}

