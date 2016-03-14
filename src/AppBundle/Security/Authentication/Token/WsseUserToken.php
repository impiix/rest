<?php
/**
 * Date: 1/26/16
 * Time: 12:40 PM
 */
namespace AppBundle\Security\Authentication\Token;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

/**
 * Class WsseUserToken
 * @package AppBundle\Security\Authentication\Token
 */
class WsseUserToken extends AbstractToken
{
    public function __construct(array $roles = [])
    {
        parent::__construct($roles);

        $this->setAuthenticated(count($roles) > 0);
    }

    public function getCredentials()
    {
        return '';
    }
}
