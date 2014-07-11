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
        return [
            new \Twig_SimpleFilter('ang', [$this, 'ang'], [
                'pre_escape' => 'html',
                'is_safe' => ['html']
            ])
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('jsonErrors', [$this, 'jsonErrors']),
            new \Twig_SimpleFunction('jsonAllErrors', [$this, 'jsonAllErrors']),
            new \Twig_SimpleFunction('attrs', [$this, 'attrs'], ['needs_environment' => true])
        ];
    }


    public function jsonAllErrors(FormView $form)
    {
        $errors = [];

        foreach ($form as $key => $child) {
            $errors[$key] = $this->jsonErrors($child);
        }

        return array_merge($errors, $this->jsonErrors($form));
    }

    public function jsonErrors(FormView $form)
    {
        $errors = [];

        foreach ($form->vars['errors'] as $error) {
            $errors[] = $error->getMessage();
        }

        return $errors;
    }

    public function ang($text)
    {
        return "{{" . $text . "}}";
    }

    public function attrs(\Twig_Environment $env, $attrs)
    {
        $str = "";

        foreach ($attrs as $attr => $value) {
            $value = \twig_escape_filter($env, $value, "html_attr");
            $str .= $attr . "=" . json_encode($value);
        }

        return $str;
    }


}