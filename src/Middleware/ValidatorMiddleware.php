<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exceptions\InvalidMessageException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ValidationStamp;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ValidatorMiddleware
 * @package App\Middleware
 */
final class ValidatorMiddleware implements MiddlewareInterface
{
    private ValidatorInterface $validator;

    /**
     * ValidatorMiddleware constructor.
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @throws InvalidMessageException
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        $errors = $this->validator->validate($message, null, ['default']);
        if (count($errors) > 0) {
            throw InvalidMessageException::errors($errors);
        }

        $envelope = $envelope->with(new ValidationStamp(['default']));

        return $stack->next()->handle($envelope, $stack);
    }
}
