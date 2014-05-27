<?php

namespace Jma\BootstrapBundle\Twig;


use Symfony\Component\Form\FormView;

class BootstrapExtension extends \Twig_Extension
{
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "angular_extension";
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('ang', array($this, 'ang'), array(
                'pre_escape' => 'html',
                'is_safe' => array('html')
            ))
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('jsonErrors', array($this, 'jsonErrors')),
            new \Twig_SimpleFunction('jsonAllErrors', array($this, 'jsonAllErrors'))
        );
    }


    public function jsonAllErrors(FormView $form)
    {
        $errors = array();

        foreach ($form as $key => $child) {
            $errors[$key] = $this->jsonErrors($child);
        }

        return array_merge($errors, $this->jsonErrors($form));
    }

    public function jsonErrors(FormView $form)
    {
        $errors = array();

        foreach ($form->vars['errors'] as $error) {
            $errors[] = $error->getMessage();
        }

        return $errors;
    }

    public function ang($text)
    {
        return "{{" . $text . "}}";
    }


}