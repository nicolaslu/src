<?php

namespace Sdz\BlogUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogUserController extends Controller
{
    public function authAction()
    {
        return $this->render('SdzBlogUserBundle:Login:login.html.twig');
    }

    public function registerAction()
    {
        return $this->render('SdzBlogUserBundle:Register:register.html.twig');
    }
}
