<?php
/**
 * @copyright Copyright (c) 2019 Ubuxa (By Epsolun Ltd)
 * @author Anthony Okechukwu, inspirations by  Nicolò Martini <nicmartnic@gmail.com> [but completely re-written and addapted for Yii2]
 */

namespace boffins_vendor\classes\Tree;


//use yii\base\ArrayableTrait;
//use yii\base\ArrayAccessTrait;
use yii\base\InvalidCallException;
use yii\base\InvalidArgumentException;




trait NodeTrait 
{
	//use ArrayableTrait;
	//use ArrayAccessTrait;
	
	/**
     * @var mixed arr|int|char|str|ActiveRecord|ModelCollection
     */
    protected $value;
	
    /**
     * @var NodeInterface - the parent node -  if this is false, then this node is a root node or orphan. 
     */
    protected $parentNode = null;
	
    /**
     * @var NodeInterface[] an array of nodes which are the children of this node - 
	 * in different data structures, rules for this array determine the nature of the data structure
	 * BST = limit of 2 items, TRIE = 1, Graph = unlimited
     */
    protected $children = [];
		
    /**
     * {@inheritdoc}
     * @param mixed $value
     * @param NodeInterface[] $children
     */
    public function __construct( $value = null, array $children = [], $config = [] )
    {
		if ( !empty($value) ) {
			$this->setValue($value);
		}
        
        if ( !empty($children) ) {
            $this->setChildren($children);
		}
        
		
		parent::__construct($config);
    }
	
    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
	
    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }
	
    /***
     * Adds a child node
	 * @params NodeInterface $node 
	 * if $node simply adds this node as` a new child node
	 * @return $this instance 
     */
    public function addChildNode($node)
    {
		if ( $node instanceof NodeInterface ) {
			$node->setParent($this);
			$this->children[] = $node;
		} else {
			throw new InvalidArgumentException("You can use this function to add an object of NodeInterface. If you want to add any other type of object, please use addChildValue() " . self::className() );
		}
        return $this; 
    }
	
    /***
     * Adds a child node using a value
	 * @params mixed - array|string|int|ActiveRecord $value (in reality it can be any type as there is no check)
	 * @return $this instance 
     */
    public function addChildValue($value)
    {
		$child = new static($value); //new static creates a new instance of this class or subclass 
		$child->setParent($this);
		$this->children[] = $child;
        return $this; 
    }
	
    /***
     *  @brief Remove any child node which has a given value. 
     *  
     *  @param [mixed] $value a value you want to remove from the Tree (sub tree of this node)
     *  @param [bool] $strictlyOnce set this to true if you only the first occurence to be removed. 
     */
    public function removeChildValue($value, $strictlyOnce = false)
    {
        foreach ($this->getChildren() as $key => $myChild) {
			if ($myChild->value == $value) {
				unset($this->children[$key]);
				$this->children = array_values($this->children);
				$nodeChild->setParent(null);
				if ($strictlyOnce) { break; } //just messing around here. refactor this. 
			}
		}
	}
	
	/***
	 *  @brief Remove a child node. 
	 *  
	 *  @param [NodeInterface] $nodeChild Description for $nodeChild
	 *  @param [bool] $compareStrict Compare the nodes strictly so that it only eliminates the same instance (default) not a similar instance
	 *  @return Return description
	 *  
	 *  @details Comparison by default will only eliminate the same instance of the node. 
	 *  If you only want to remove any SIMILAR instance, you have to set $compareStrict to false. 
	 */
	public function removeChildNode(Node &$nodeChild, $compareStrict = true)
	{
        foreach ($this->getChildren() as $key => $myChild) {
			if ( ($compareStrict && $nodeChild === $myChild) || (!$compareStrict && $nodeChild == $myChild) ) {
				unset($this->children[$key]);
				$this->children = array_values($this->children); //reset the array so that it does not contain a null value
				$nodeChild->setParent(null);
				break;
			}
			return $this; //terminate the loop - it will only remove the first node. 
        }
        
    }
	
	/***
	 *  @brief function to remove a this node from a tree. 
	 *  
	 *  @param [bool] $reassign indicate whether or not to reassign child nodes
	 *  @param [NodeInterface] $newParentNode a parent node to reassign the child nodes - 
	 *  		if this is null, then child nodes are reassigned to this parent
	 *  @return void - this should be a terminal function i.e. no subsequent chaining 
	 *  
	 */
	public function removeFromTree($reassign = false, $newParentNode = null)
	{
		$this->getParent()->removeChildNode($this);
		if ( $reassign ) {
			if ( empty($newParentNode) ) {
				$newParentNode = $this->getParent();
			}
			foreach($this->getChildren() as $child) {
				$child->parent = $newParentNode;
			}
		}
		$this->removeAllChildren();
	}
	
    /***
     * @brief removes all children of this node
	 * @return $this instance 
     */
    public function removeAllChildren()
    {
        $this->setChildren([]);
        return $this;
    }
	
    /**()
     * @brief returns all the children of this node. 
     */
    public function getChildren()
    {
        return $this->children;
    }
	
    /**
     * @brief will set children to a new set. 
	 * @return $this instance 
     */
    public function setChildren(array $children)
    {
        $this->children = [];
        foreach ($children as $child) {
            $this->addChildNode($child);
        }
        return $this;
    }
	
    /**
     * {@inheritdoc}
     * sets the parent node (detaches from any existing parent first)
	 * @return $this instance 
     */
    public function setParent(NodeInterface $parent)
    {
		if ( !empty($this->parentNode) ) {
			$this->parentNode->removeChildNode($this);
		}
        $this->parentNode = $parent;
		return $this;
		
    }
	
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parentNode;
    }
	
    /**
     * returns all ancestors (parents, grandparents etc)
     */
    public function getAncestors()
    {
        $parents = [];
        $node = $this;
        while ($parent = $node->getParent() && !empty($parent) ) { //if parent is false, this terminates 
            array_unshift($parents, $parent);
            $node = $parent;
        }
        return $parents;
    }
	
    /**
     * returns ancestors and this instance
     */
    public function getAncestorsAndSelf()
    {
        return array_merge($this->getAncestors(), [$this]);
    }
	
    /**
     * returns all sibling nodes i.e. all parent's children except self 
     */
    public function getSiblings()
    {
        $neighbors = $this->getParent()->getChildren();
        $current = $this;
        // Uses array_values to reset indexes after filter as array filter preserves original keys 
        return array_values(
            array_filter(
                $neighbors,
                function ($item) use ($current) {
                    return $item !== $current;
                }
            )
        );
    }
	
    /**
     * returns all sibling nodes i.e. all parent's children including self 
     */
    public function getSiblingsAndSelf()
    {
        return $this->getParent()->getChildren();
    }
	
    /**
     * @return bool 
     */
    public function isLeaf()
    {
        return empty($this->getChildren());
    }
	
    /**
     * @return bool
     */
    public function isRoot()
    {
        return $this->getParent() === null;
    }
	
    /**
     * @return bool
     */
    public function isChild()
    {
        return $this->getParent() !== null;
    }
	
    /**
     * Find the root of the node
     *
     * @return NodeInterface
     */
    public function root()
    {
        $node = $this;
        while ($parent = $node->getParent() && !empty($parent) )
            $node = $parent;
        return $node;
    }
	
    /**
     * Return the distance from the current node to the root.
     *
     * Warning, can be expensive, since each descendant is visited
     *
     * @return int
     */
    public function getDepth()
    {
        if ($this->isRoot()) {
            return 0;
        }
        return $this->getParent()->getDepth() + 1;
    }
	
    /**
     * Return the height of the tree whose root is this node
     *
     * @return int
     */
    public function getHeight()
    {
        if ($this->isLeaf()) {
            return 0;
        }
        $heights = [];
        foreach ($this->getChildren() as $child) {
            $heights[] = $child->getHeight();
        }
        return max($heights) + 1;
    }
	
    /**
     * Return the number of nodes in a tree
     * @return int
     */
    public function getSize()
    {
        $size = 1;
        foreach ($this->getChildren() as $child) {
            $size += $child->getSize();
        }
        return $size;
    }
	
    /**
     * {@inheritdoc}
     */
    public function accept(Visitor $visitor)
    {
        return $visitor->visit($this);
    }
}