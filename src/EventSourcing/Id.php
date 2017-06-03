<?php namespace OrderFulfillment\EventSourcing;

abstract class Id {

    /** @var string */
    protected $id;

    protected function __construct($id) {
        $this->id = $id;
    }

    public static function fromString($id) : Id {
        if ( ! is_string($id)) {
            throw new \InvalidArgumentException("Tried to create " . static::class . " from string but received type " . (is_object($id) ? get_class($id) : $id) . '.');
        }
        return new static($id);
    }

    public function toString() : string {
        return $this->id;
    }

    public function __toString() : string {
        return $this->toString();
    }

    public function equals(self $that) : bool {
        if (get_class($this) !== get_class($that)) {
            throw new CannotCompareDifferentIds;
        }
        return $this->id === $that->id;
    }
}
