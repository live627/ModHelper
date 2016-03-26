<?php

namespace ModHelper;

/**
 * @copyright Copyright (c) 2015 John Rayes
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @package ModHelper
 * @version 2.0
 */

class SimpleXMLElement extends \SimpleXMLElement
{
    /**
     * Adds a CDATA property to an XML document.
     * http://stackoverflow.com/a/20511976
     *
     * @param string $name Name of property that should contain CDATA.
     * @param string $value Value that should be inserted into a CDATA child.
     * @return SimpleXmlElement
     */
    public function addChildWithCDATA($name, $value = NULL) {
        $xmlChild = $this->addChild($name);

        if ($xmlChild !== NULL) {
            $node = dom_import_simplexml($xmlChild);
            $no = $node->ownerDocument;
            $node->appendChild($no->createCDATASection($value));
        }
        return $xmlChild;
    }

    /**
     * Create XML using string or array
     * http://php.net/manual/en/simplexmlelement.addchild.php#111087
     *
     * @param mixed $data input data
     * @param string $child name of first level child
     * @return SimpleXmlElement
     */
    function array2XML(array $data, $child = 'item')
    {
        foreach ($data as $key => $val) {
            if (is_array($val)) {
                if (is_numeric($key)) {
                    $key = $child;
                }
                $this->addChild($key, $this->array2XML($val, $child));
            } else {
                $this->addChild($key, $val);
            }
        }
        return $this;
    }
}
