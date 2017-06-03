<?php namespace spec\OrderFulfillment\PhpSpec;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\Matcher;

class EqualValueMatcher implements Matcher {

    /**
     * Checks if matcher supports provided subject and matcher name.
     *
     * @param string $name
     * @param mixed $subject
     * @param array $arguments
     *
     * @return Boolean
     */
    public function supports($name, $subject, array $arguments) {
        return $name == 'equalValue';
    }

    /**
     * Evaluates positive match.
     *
     * @param string $name
     * @param mixed $subject
     * @param array $arguments
     */
    public function positiveMatch($name, $subject, array $arguments) {
        // compare scalars
        if (is_scalar($subject) && is_scalar($arguments[0])) {
            return $subject === $arguments[0];
        }
        // don't compare scalars vs objects
        if (is_scalar($subject) || is_scalar($arguments[0])) {
            $item1 = is_scalar($subject) ? "<label>scalar</label> value <value>{$subject}</value>" : '<label>object</label> of type <value>' . get_class($subject) . '</value>';
            $item2 = is_scalar($arguments[0]) ? "<label>scalar</label> value <value>{$arguments[0]}</value>" : '<label>object</label> of type <value>' . get_class($arguments[0]) . '</value>';
            throw new FailureException("Cannot compare $item1 with $item2.");
        }
        // compare objects
        if (get_class($subject) !== get_class($arguments[0])) {
            throw new FailureException("Values of types <label>" . get_class($subject) . "</label> and <label>" . get_class($arguments[0]) . "</label> cannot be compared.");
        }
        if ( ! $subject->equals($arguments[0])) {
            throw new FailureException('Value of type <label>' . get_class($subject) . "</label> <value>{$subject->toString()}</value> should equal <value>{$arguments[0]->toString()}</value> but does not.");
        }
    }

    /**
     * Evaluates negative match.
     *
     * @param string $name
     * @param mixed $subject
     * @param array $arguments
     */
    public function negativeMatch($name, $subject, array $arguments) {
        if ($subject->equals($arguments[0])) {
            throw new FailureException('<label>' . get_class($subject) . "</label> <value>{$subject->toString()}</value> should not equal <value>{$arguments[0]->toString()}</value> but does.");
        }
    }

    /**
     * Returns matcher priority.
     *
     * @return integer
     */
    public function getPriority() {

    }
}