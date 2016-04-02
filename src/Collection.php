<?php

namespace ModHelper;

/**
 * @package ModHelper
 * @since 1.0
 */
class Collection extends \ArrayObject 
{	/**
	 * Retrieve an external iterator.
	 *
	 * @access public
	 * @abstracting \IteratorAggregate
	 * @since 1.0
	 */
	public function getIterator()
	{
		foreach ($this as $id => $item) {
			yield $id => $item;
		}
	}

	/**
	 * Construct the object.
	 *
	 * @access public
	 * @param array
	 * @abstracting \ArrayObject
	 * @since 2.0
	 */
    function __construct(array $array=[]){
        parent::__construct($array,parent::STD_PROP_LIST|parent::ARRAY_AS_PROPS);
    } 
  public function addValue($v) {
    return $this->offsetSet(NULL, $v);
  } 
}
