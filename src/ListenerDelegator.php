<?php
/**
 * Copyright (c) 2017 Stickee Technology Limited
 * Copyright (c) 2017 - 2019 Martin Meredith <martin@sourceguru.net>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Mez\Sentry;

use Interop\Container\ContainerInterface;
use Mez\Sentry\Listener\Listener;
use Zend\ServiceManager\Factory\DelegatorFactoryInterface;

/**
 * Class ListenerDelegator
 *
 * @package Mez\Sentry
 */
class ListenerDelegator implements DelegatorFactoryInterface
{
    /**
     * A factory that creates delegates of a given service
     *
     * @param  ContainerInterface $container
     * @param  string $name
     * @param  callable $callback
     * @param  null|array $options
     *
     * @return \Zend\Stratigility\Middleware\ErrorHandler
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        /** @var Listener $listener */
        $listener = $container->get(Listener::class);

        /** @var \Zend\Stratigility\Middleware\ErrorHandler $errorHandler */
        $errorHandler = $callback();

        $errorHandler->attachListener($listener);

        return $errorHandler;
    }
}
