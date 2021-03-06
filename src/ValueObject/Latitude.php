<?php
declare(strict_types=1);

namespace Dwr\GameOfLive\ValueObject;

final class Latitude extends Natural implements ValueObjectInterface
{
    /**
     * @param ValueObjectInterface $object
     * @return bool
     */
    public function equals(ValueObjectInterface $object) : bool
    {
        if ($object instanceof Latitude) {
            return $this->value === $object->value;
        }

        return false;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return (string) $this->value;
    }
}
