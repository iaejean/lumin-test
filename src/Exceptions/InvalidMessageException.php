<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class InvalidMessageException
 * @package App\Exceptions
 */
class InvalidMessageException extends \Exception
{
    /**
     * InvalidMessageException constructor.
     * @param string $message
     */
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    /**
     * @param $errors
     * @return InvalidMessageException
     */
    public static function errors(ConstraintViolationListInterface $constraints): InvalidMessageException
    {
        $errors = [];

        foreach ($constraints as $error) {
            if (is_scalar($error->getInvalidValue())) {
                $errors[] = trim(
                    sprintf(
                        '%s (%s) %s',
                        $error->getInvalidValue(),
                        $error->getPropertyPath(),
                        mb_strtolower($error->getMessage())
                    )
                );
                continue;
            }
            $errors[] = trim(sprintf('%s %s', $error->getPropertyPath(), mb_strtolower($error->getMessage())));
        }

        return new InvalidMessageException('Invalid message: ' . implode(', ', $errors));
    }

    /**
     * @return InvalidMessageException
     */
    public static function missingContent(): InvalidMessageException
    {
        return new InvalidMessageException('missing content');
    }

    /**
     * @return InvalidMessageException
     */
    public static function alreadyExist(): InvalidMessageException
    {
        return new InvalidMessageException('already exists');
    }
}
