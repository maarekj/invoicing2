<?php
/**
 * Created by PhpStorm.
 * User: maarek
 * Date: 02/04/2014
 * Time: 15:45
 */

namespace Jma\Invoicing\AppBundle\Controller;

use Jma\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

class InvoiceController extends ResourceController
{
    public function updateAction(Request $request)
    {
        $resource = $this->findOr404($request);
        $form = $this->getForm($resource);

        if (($request->isMethod('PUT') || $request->isMethod('POST')) && $form->submit($request)->isValid()) {
            $this->domainManager->update($resource);

            return $this->redirectHandler->redirectTo($resource);
        }

        if ($this->config->isApiRequest()) {
            return $this->handleView($this->view($form));
        }

        $templateData = array(
            $this->config->getResourceName() => $resource,
            'form' => $form->createView()
        );

        $view = $this
            ->view()
            ->setTemplate($this->getConfiguration()->getTemplate('update.html'))
            ->setData($this->updateTemplateExtraData($request, $templateData));

        return $this->handleView($view);
    }
} 