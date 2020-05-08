<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Message;
use App\Entity\Subscriber;
use App\Entity\Topic;
use App\Message\Command\PublishMessage;
use App\Message\Command\RegisterEvent;
use App\Message\Command\SubscribeEvent;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PublisherController
 * @package App\Controller
 *
 * @SWG\Tag(name="Publisher")
 * @SWG\Response(response="201", description="Request processed succesfully")
 * @SWG\Response(
 *     response="500",
 *     description="An unexpected erros has ocurred",
 *     @SWG\Schema(
 *          type="object",
 *          title="ErrorResponse",
 *          @SWG\Property(type="string", property="message")
 *     )
 * )
 */
final class PublisherController extends AbstractController
{
    /**
     * @SWG\Post(produces={"application/json"})
     * @SWG\Parameter(
     *     name="SubscriberRequest",
     *     in="body",
     *     @Model(type=Subscriber::class, groups={"default"})
     * )
     * @Route(methods={"POST"}, path="subscribe/{topic}")
     * @ParamConverter(name="subscriber", class="App\Entity\Subscriber")
     * @param string $topic
     * @param Subscriber $subscriber
     * @return Response
     */
    public function postSubscribeAction(string $topic, Subscriber $subscriber): Response
    {
        $this->dispatchMessage(new SubscribeEvent($subscriber, Topic::create($topic)));

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @SWG\Post(produces={"application/json"})
     * @Route(methods={"POST"}, path="publish/{topic}")
     * @SWG\Parameter(
     *     name="MessageRequest",
     *     in="body",
     *     @Model(type=Message::class, groups={"default"})
     * )
     * @ParamConverter(name="message", class="App\Entity\Message")
     * @param string $topic
     * @param Message $message
     * @return Response
     */
    public function postPublishAction(string $topic, Message $message): Response
    {
        $this->dispatchMessage(new PublishMessage($message, Topic::create($topic)));

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @SWG\Post(produces={"application/json"})
     * @Route(methods={"POST"}, path="event")
     * @SWG\Parameter(
     *     name="EventRequest",
     *     in="body",
     *     @Model(type=Event::class, groups={"default"})
     * )
     * @ParamConverter(name="event", class="App\Entity\Event")
     * @param Event $event
     * @return Response
     */
    public function postEventAction(Event $event): Response
    {
        $this->dispatchMessage(new RegisterEvent($event));

        return new Response('', Response::HTTP_CREATED);
    }
}
