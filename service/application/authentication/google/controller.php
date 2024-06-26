<?php
namespace Application\Authentication\Google;

defined('C5_EXECUTE') or die('Access Denied');

class Controller extends \Concrete\Authentication\Google\Controller
{
    protected const NON_ALLOWED_EMAILS_PREFIXES = ['alunos.', 'turmas.', 'al.', 'a.'];

    public function supportsRegistration()
    {
        $extractor = $this->getExtractor();
        $email = $extractor->getEmail();
        if(!$email) {
            return false;
        }
        foreach (self::NON_ALLOWED_EMAILS_PREFIXES as $disallow) {
            if (strpos($email, $disallow) === 0) {
                return false;
            }
        }
        return true;
        // return \Config::get('auth.google.registration.enabled', false);
    }
}