XhProf grapher
==============

[![Latest Stable Version](https://poser.pugx.org/csa/xhprof-grapher/v/stable.png)](https://packagist.org/packages/csa/xhprof-grapher "Latest Stable Version")
[![Latest Unstable Version](https://poser.pugx.org/csa/xhprof-grapher/v/unstable.png)](https://packagist.org/packages/csa/xhprof-grapher "Latest Unstable Version")
[![SensioLabs Insight](https://insight.sensiolabs.com/projects/f6d11755-620b-4d66-a72a-6fe1932da840/mini.png)](https://insight.sensiolabs.com/projects/f6d11755-620b-4d66-a72a-6fe1932da840 "SensioLabs Insight")
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/csarrazi/xhprof-grapher/badges/quality-score.png?s=484350c9cfd7b2205d8f1e3860eeeb4f2d477a9a)](https://scrutinizer-ci.com/g/csarrazi/xhprof-grapher/ "Scrutinizer Quality Score")
[![Code Coverage](https://scrutinizer-ci.com/g/csarrazi/xhprof-grapher/badges/coverage.png?s=a0d8619485ec8ac5b13353bb089a69ff4909922c)](https://scrutinizer-ci.com/g/csarrazi/xhprof-grapher/ "Code Coverage")

Installation
------------

    composer require csa/xhprof-grapher:dev-master

Usage
-----

Create any type of PHP web or console application, then use the following in your code

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use XhProf\Storage\FileStorage;
use XhProf\Graph\Loader\XhProfDataLoader as Loader;
use XhProf\Graph\Dumper\GraphvizDumper as Dumper;

$storage = new FileStorage();
$loader = new Loader();
$graph = $loader->load($storage, '1234567890abcdef');
$dumper = new Dumper();

if ('cli' === php_sapi_name()) {
    header('Content-type: image/png');
}

echo $dumper->dump($graph);
```

Todo
----

* Add support for loading exclusive metrics
* Add support for aggregating metrics
* Improve graphviz callgraph
* Add support for other graphing outputs (graphdracula, arborjs, flare, js-graph-it, etc.)

License
-------

This library is under the MIT license. For the full copyright and license
information, please view the LICENSE file that was distributed with this source
code.

