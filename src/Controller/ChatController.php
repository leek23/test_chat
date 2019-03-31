<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Message;

class ChatController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('chat/chat.html.twig');
    }

    /**
     * @Route("/ping", name="ping")
     *
     * @return int
     */
    public function ping()
    {
        $messages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findBy(
                array(),
                array('date_time' => 'DESC'),
                12
            );
        return $this->render('chat/messages.html.twig', array('messages'=>$messages));
    }

    /**
     * @Route("/add", name="add")
     *
     * @return JsonResponse
     */
    public function add(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $message = new Message();

        $message->setMessage($request->get('mess'));
        $message->setUser($user);

        $message->setDateTime();

        $entityManager->persist($message);
        $entityManager->flush();

        return new JsonResponse($this->getUser()->getId());
    }
}