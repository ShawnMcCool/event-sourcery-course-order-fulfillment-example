<?php namespace spec\OrderFulfillment\PhpSpec;

use PhpSpec\CodeAnalysis\AccessInspector;
use PhpSpec\Exception\ExceptionFactory;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Formatter\Presenter\Presenter;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\Loader\Node\ExampleNode;

use PhpSpec\Wrapper\Subject\WrappedObject;
use PhpSpec\Wrapper\Subject\Caller;
use PhpSpec\Wrapper\Subject\SubjectWithArrayAccess;
use PhpSpec\Wrapper\Subject\ExpectationFactory;
use PhpSpec\Wrapper\Wrapper as BaseWrapper;

class Wrapper extends BaseWrapper
{
    private $matchers;
    private $presenter;
    private $dispatcher;
    private $example;
    private $accessInspector;

    public function __construct(MatcherManager $matchers, Presenter $presenter,
                                EventDispatcherInterface $dispatcher, ExampleNode $example, AccessInspector $accessInspector)
    {
        $this->matchers = $matchers;
        $this->presenter = $presenter;
        $this->dispatcher = $dispatcher;
        $this->example = $example;
        $this->accessInspector = $accessInspector;
    }

    public function wrap($value = null)
    {
        $exceptionFactory   = new ExceptionFactory($this->presenter);
        $wrappedObject      = new WrappedObject($value, $this->presenter);
        $caller             = new Caller(
            $wrappedObject,
            $this->example,
            $this->dispatcher,
            $exceptionFactory,
            $this,
            $this->accessInspector
        );

        $arrayAccess        = new SubjectWithArrayAccess($caller, $this->presenter, $this->dispatcher);
        $expectationFactory = new ExpectationFactory($this->example, $this->dispatcher, $this->matchers);

        return new Subject(
            $value, $this, $wrappedObject, $caller, $arrayAccess, $expectationFactory
        );
    }
}
