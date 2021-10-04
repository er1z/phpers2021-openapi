<?php


namespace App\Presentation\User;


use App\Presentation\User\Struct\SomeUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class UsersController
{
    private SerializerInterface $serializer;

    public function __construct(
        SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }


    /**
     * @Route(path="/api/users", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="list users",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=SomeUser::class))
     *     )
     * )
     */
    public function __invoke(): JsonResponse
    {
        $result = [
            new SomeUser('DarthVader42', 'boss@buzi.pl')
        ];

        return new JsonResponse(
            $this->serializer->serialize($result, 'json'), JsonResponse::HTTP_OK, [], true
        );
    }
}