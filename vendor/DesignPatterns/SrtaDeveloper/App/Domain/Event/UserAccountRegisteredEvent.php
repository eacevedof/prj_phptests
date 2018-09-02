<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\SrtaDeveloper\App\Domain\Event\UserAccountRegisteredEvent
 * @file UserAccountRegisteredEvent.php
 * @version 1.0.0
 * @date 02-09-2018 17:21
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\SrtaDeveloper\App\Domain\Event;

class UserAccountRegisteredEvent 
{
    /**
     * @var int
     */
    private $userAccountId;
    /**
     * @var \DateTime
     */    
    private $ocurredOn;

    public function __construct($userAccountId)
    {
        $this->userAccountId = $userAccountId;
        $this->ocurredOn = new \DateTime();

    }//_construct

    public function getUserAccountId()
    {
        return $this->userAccountId;
    }//getUserAccountId

    public function getOcurredOn()
    {
        return $this->ocurredOn;
    }//getOcurredOn

}//UserAccountRegisteredEvent