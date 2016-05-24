<?php
namespace UserBundle\Handler;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;

class AuthenticationHandler
    implements AuthenticationSuccessHandlerInterface,
    AuthenticationFailureHandlerInterface
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($request->isXmlHttpRequest()) {
            $result = array('success' => true);
            $response = new Response(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            if ($targetPath = $request->getSession()->get('_security.target_path')) {
                $url = $targetPath;
            } else {
                $url = $this->router->generate('user_homepage');
            }
            return new RedirectResponse($url);
        }
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($request->isXmlHttpRequest()) {
            $result = $exception->getMessage();
            $response = new Response(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');
            $response->setStatusCode(400);
            return $response;
        } else {
            $request->getSession()->set(SecurityContext::AUTHENTICATION_ERROR, $exception);
            $url = $this->router->generate('user_homepage');
            return new RedirectResponse($url);
        }
    }
}