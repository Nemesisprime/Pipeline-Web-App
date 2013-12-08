<?php

namespace Pipeline\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class HomeController extends Controller
{
    /**
     * @Route("")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
