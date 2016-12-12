<?php

namespace AutocompletionBundle\Controller;

use AutocompletionBundle\Repository\TownRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AutocompletionBundle\Entity\Town;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AutocompletionBundle:Default:index.html.twig');
    }

    /**
     * @Route("/ajax-town/{input}", name="ajaxTown")
     * @Method("POST")
     */
    public function getTownAction ($input, Request $request)
    {
        if ($request->isXmlHttpRequest() ) {
            if (strlen($input)<3) {
                $towns='';
            } else {
                $em = $this->getDoctrine()->getManager();
                $towns = $em->getRepository('AutocompletionBundle:Town')->findAjaxTown($input);
            }
            return new JsonResponse(array("data" => json_encode($towns)));
        } else {
            throw new HttpException('500', 'Invalid call');
        }
    }
}
