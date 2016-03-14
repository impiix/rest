<?php
/**
 * Date: 2/11/16
 * Time: 5:19 PM
 */
namespace AppBundle\Event\Listener;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Class ModifyResponse
 * @package AppBundle\Event\Listener
 */
class ModifyResponse
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (!$request->headers->has("Accept") || strpos($request->headers->get("Accept"), 'text/html') === false) {
            return;
        }

        $response = $event->getResponse();

        if ($request->getRequestFormat() !== 'json') {
            return;
        }

        $prettyPrintLang = 'js';
        $content = json_encode(json_decode($response->getContent()), JSON_PRETTY_PRINT);


        $response->setContent(
            '<html><body>' .
            '<pre class="prettyprint lang-' . $prettyPrintLang . '">' .
            htmlspecialchars($content) .
            '</pre>' .
            '<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>' .
            '</body></html>'
        );

        $response->headers->set("Content-Type", "text/html; charset=utf-8");
        $request->setRequestFormat("html");

        // $response->headers->set("Content-Type", "application/vnd.api+json");

        $event->setResponse($response);
    }
}
