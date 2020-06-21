<?php declare(strict_types=1);

namespace App\Application\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Webmozart\Assert\Assert;

class ErrorResponse extends JsonResponse
{
    public const INVALID_REQUEST = 'invalid_request';
    public const UNAUTHORIZED_CLIENT = 'unauthorized_client';
    public const ACCESS_DENIED = 'access_denied';
    public const UNSUPPORTED_RESPONSE_TYPE = 'unsupported_response_type';
    public const INVALID_SCOPE = 'invalid_scope';
    public const SERVER_ERROR = 'server_error';
    public const TEMPORARILY_UNAVAILABLE = 'temporarily_unavailable';

    private const MESSAGES = [
        self::INVALID_REQUEST => 'The request is missing a required parameter, includes an
               invalid parameter value, includes a parameter more than
               once, or is otherwise malformed.',
        self::UNAUTHORIZED_CLIENT => 'The client is not authorized to request an authorization
               code using this method.',
        self::ACCESS_DENIED => 'The resource owner or authorization server denied the
               request.',
        self::UNSUPPORTED_RESPONSE_TYPE => 'The authorization server does not support obtaining an
               authorization code using this method.',
        self::INVALID_SCOPE => 'The requested scope is invalid, unknown, or malformed.',
        self::SERVER_ERROR => 'The authorization server encountered an unexpected
               condition that prevented it from fulfilling the request.',
        self::TEMPORARILY_UNAVAILABLE => 'The authorization server is currently unable to handle
               the request due to a temporary overloading or maintenance
               of the server.'
    ];

    private const CODES = [
        self::INVALID_REQUEST => 400,
        self::UNAUTHORIZED_CLIENT => 400,
        self::ACCESS_DENIED => 400,
        self::UNSUPPORTED_RESPONSE_TYPE => 400,
        self::INVALID_SCOPE => 400,
        self::SERVER_ERROR => 500,
        self::TEMPORARILY_UNAVAILABLE => 500,
    ];

    public function __construct(string $error, string $errorUri = '', string $state = '')
    {
        Assert::inArray($error, array_keys(self::MESSAGES), 'Invalid error code given');
        Assert::inArray($error, array_keys(self::CODES), 'Code is not implemented');

        parent::__construct([
            'error' => $error,
            'error_description' => self::MESSAGES[$error],
            'error_uri' => $errorUri,
            'state' => $state,
        ], self::CODES[$error]);
    }
}
