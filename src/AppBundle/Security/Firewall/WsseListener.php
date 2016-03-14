<?php
/**
 * Date: 1/26/16
 * Time: 12:43 PM
 */
namespace AppBundle\Security\Firewall;
use AppBundle\Security\Authentication\Token\WsseUserToken;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

/**
 * Class WsseListener
 * @package AppBundle\Security\Firewall
 */
class WsseListener implements ListenerInterface
{
    protected $tokenStorage;

    protected $authenticationManager;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        AuthenticationManagerInterface $authenticationManager
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
    }

    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $wsseRegex = '/UsernameToken Username="([^"]+)", PasswordDigest="([^"]+)", Nonce="([^"]+)", Created="([^"]+)"/';
        if (!$request->headers->has('x-wsse')
            || preg_match($wsseRegex, $request->headers->get('x-wsse'), $matches) !== 1) {
            return;
        }

        $token = new WsseUserToken();
        $token->setUser($matches[1]);

        $token->digest = $matches[2];
        $token->nonce = $matches[3];
        $token->created = $matches[4];

        try {
            $authToken = $this->authenticationManager->authenticate($token);
            $this->tokenStorage->set($authToken);

            return;
        } catch (AuthenticationException $failed) {

        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_FORBIDDEN);
        $event->setResponse($response);
    }
}
