<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Answer;


use App\Application\Answers\AnswersListQuery;
use App\Infrastructure\JsonApi\SymfonyParameterReader;
use App\UserInterface\AuthenticationAwareController;
use App\UserInterface\AuthenticationAwareMethods;
use Slick\JSONAPI\Document\DocumentEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * AnswerListController
 *
 * @package App\UserInterface\Answers
 */
final class AnswersListController extends AbstractController implements AuthenticationAwareController
{

    use AuthenticationAwareMethods;

    public function __construct(
        private readonly AnswersListQuery $listQuery,
        private readonly DocumentEncoder $encoder
    ) {
    }

    #[Route(path: "/answers", methods: ["GET"])]
    public function handle(Request $request): Response
    {
        $parameterReader = new SymfonyParameterReader($request);
        $owner = AnswersListQuery::OWNER_ALL;
        $queryFilter = $request->query->all('filter');

        if (array_key_exists(AnswersListQuery::OWNER_FILTER, $queryFilter)) {
            $owner = $queryFilter[AnswersListQuery::OWNER_FILTER];
        }

        $answersList = $this->listQuery
            ->withParameterReader($parameterReader)
            ->withParam(AnswersListQuery::PARAM_USER_ID, $this->user()->userId())
            ->withParam(AnswersListQuery::OWNER_FILTER, $owner);

        return new Response(
            content: $this->encoder->encode($answersList),
            headers: ['content-type' => 'application/vnd.api+json']
        );
    }
}