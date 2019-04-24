<?php
/**
 * @copyright Copyright (c) 2019 Ubuxa (By Epsolun Ltd)
 * @author Anthony Okechukwu, inspirations by  Nicolò Martini <nicmartnic@gmail.com> [but completely re-written and addapted for Yii2]
 */

namespace boffins_vendor\classes\Tree;

use Yii;
use IteratorAggregate;
use Countable;
use yii\base\BaseObject;

/**
 */
class Node extends BaseObject implements NodeInterface
{
	use NodeTrait;
}