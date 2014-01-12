<?php

/*
 * This file is part of the XhProf Grapher package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace XhProf\Graph\Loader;

use XhProf\Graph\Loader\LoadingStrategy\InclusiveLoadingStrategy;
use XhProf\Storage\StorageInterface;

class XhProfDataLoader
{
    private $strategy;

    public function __construct(StrategyInterface $strategy = null)
    {
        $this->strategy = $strategy ?: new InclusiveLoadingStrategy();
    }

    public function load(StorageInterface $storage, $token)
    {
        $trace = $storage->fetch($token);

        return $this->strategy->load($trace);
    }
}
