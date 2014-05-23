<?php

namespace Jma\BootstrapBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Sensio\Bundle\FrameworkExtraBundle\Security\ExpressionLanguage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class SecurityControllerListener
{
    private $securityContext;
    private $language;
    private $trustResolver;
    private $roleHierarchy;

    public function __construct(SecurityContextInterface $securityContext = null, ExpressionLanguage $language = null, AuthenticationTrustResolverInterface $trustResolver = null, RoleHierarchyInterface $roleHierarchy = null)
    {
        $this->securityContext = $securityContext;
        $this->language = $language;
        $this->trustResolver = $trustResolver;
        $this->roleHierarchy = $roleHierarchy;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        if (!$expression = $request->attributes->get('_jma_security')) {
            return;
        }

        if (null === $this->securityContext || null === $this->trustResolver) {
            throw new \LogicException('To use the @Security tag, you need to install the Symfony Security bundle.');
        }

        if (!$this->language->evaluate($expression, $this->getVariables($request, $event->getController()))) {
            throw new AccessDeniedException(sprintf('Expression "%s" denied access.', $expression));
        }
    }

    // code should be sync with Symfony\Component\Security\Core\Authorization\Voter\ExpressionVoter
    private function getVariables(Request $request, $controller = null)
    {
        $token = $this->securityContext->getToken();

        if (null !== $this->roleHierarchy) {
            $roles = $this->roleHierarchy->getReachableRoles($token->getRoles());
        } else {
            $roles = $token->getRoles();
        }

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        $variables = array(
            'token' => $token,
            'user' => $token->getUser(),
            'object' => $request,
            'request' => $request,
            'controller' => $controller,
            'roles' => array_map(function ($role) { return $role->getRole(); }, $roles),
            'trust_resolver' => $this->trustResolver,
            'security_context' => $this->securityContext,
        );

        // controller variables should also be accessible
        return array_merge($request->attributes->all(), $variables);
    }
}
