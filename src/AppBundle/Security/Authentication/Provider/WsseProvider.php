<?php
/**
 * Date: 1/26/16
 * Time: 12:56 PM
 */
namespace AppBundle\Security\Authentication\Provider;
use AppBundle\Security\Authentication\Token\WsseUserToken;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class WsseProvider
 * @package AppBundle\Security\Authentication\Provider
 */
class WsseProvider implements AuthenticationProviderInterface
{
    private $userProvider;
    private $cacheDir;

    public function __construct(UserProviderInterface $userProvider, $cacheDir)
    {
        $this->userProvider = $userProvider;
        $this->cacheDir = $cacheDir;
    }

    public function authenticate(TokenInterface $token)
    {
        $user = $this->userProvider->loadUserByUsername($token->getUsername());

        if ($user && $this->validateDigest($token->digest, $token->nonce, $token->created, $user->getPassword())) {
            $authenticatedToken = new WsseUserToken($user->getRoles());
            $authenticatedToken->setUser($user);

            return $authenticatedToken;
        }

        throw new AuthenticationException('wsse authentication failed.');
    }

    protected function validateDigest($digest, $nonce, $created, $secret)
    {
        if (strtotime($created) > time()) {
            return false;
        }

        if (time() - strtotime($created) > 300) {
            return false;
        }

        if (file_exists($this->cacheDir . '/' . $nonce) && file_get_contents($this->cacheDir . '/' . $nonce))
    }
}
