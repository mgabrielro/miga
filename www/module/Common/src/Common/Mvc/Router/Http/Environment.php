<?php
/**
 * Zend Framework (http://framework.zend.com/).
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 *
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Common\Mvc\Router\Http;

use Traversable;
use Zend\Mvc\Router\Exception;
use Zend\Mvc\Router\Http\RouteInterface;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\RequestInterface as Request;

/**
 * Environment variable route.
 */
class Environment implements RouteInterface
{
    /**
     * Variable name to match.
     *
     * @var array
     */
    protected $name;

    /**
     * Variable value to match.
     *
     * @var array
     */
    protected $value;

    /**
     * Default values.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Create a new environment route.
     *
     * @param string $name
     * @param string $value
     * @param array  $defaults
     */
    public function __construct($name, $value, array $defaults = array())
    {
        $this->name = $name;
        $this->value = $value;
        $this->defaults = $defaults;
    }

    /**
     * factory(): defined by RouteInterface interface.
     *
     * @see    \Zend\Mvc\Router\RouteInterface::factory()
     *
     * @param array|Traversable $options
     *
     * @return Scheme
     *
     * @throws Exception\InvalidArgumentException
     */
    public static function factory($options = array())
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (!is_array($options)) {
            throw new Exception\InvalidArgumentException(__METHOD__.' expects an array or Traversable set of options');
        }

        if (!isset($options['name'])) {
            throw new Exception\InvalidArgumentException('Missing "name" in options array');
        }
        if (!isset($options['value'])) {
            throw new Exception\InvalidArgumentException('Missing "value" in options array');
        }

        if (!isset($options['defaults'])) {
            $options['defaults'] = array();
        }

        return new static($options['name'], $options['value'], $options['defaults']);
    }

    /**
     * match(): defined by RouteInterface interface.
     *
     * @see    \Zend\Mvc\Router\RouteInterface::match()
     *
     * @param Request $request
     *
     * @return RouteMatch|null
     */
    public function match(Request $request)
    {
        $environment = $request->getServer($this->name);

        if ($environment !== $this->value) {
            return;
        }

        return new RouteMatch($this->defaults);
    }

    /**
     * assemble(): Defined by RouteInterface interface.
     *
     * @see    \Zend\Mvc\Router\RouteInterface::assemble()
     *
     * @param array $params
     * @param array $options
     *
     * @return mixed
     */
    public function assemble(array $params = array(), array $options = array())
    {
        // An environment variable does not contribute to the path, thus nothing is returned.
        return '';
    }

    /**
     * getAssembledParams(): defined by RouteInterface interface.
     *
     * @see    RouteInterface::getAssembledParams
     *
     * @return array
     */
    public function getAssembledParams()
    {
        return array();
    }
}
