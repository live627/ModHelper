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
        $new_child = $this->addChild($name);

        if ($new_child !== NULL) {
            $node = dom_import_simplexml($new_child);
            $no = $node->ownerDocument;
            $node->appendChild($no->createCDATASection($value));
        }
        return $new_child;
    }

    /**
     * Create XML using string or array
     * http://stackoverflow.com/a/27222817
     *
     * @param array $data input data
     * @param string $root name of first level child
     * @return SimpleXmlElement
     */
    public function array2XML(array $data, $root = null)
    {
        $xml = new $this($root ? '<' . $root . '/>' : '<root/>');
        array_walk_recursive($data, function($value, $key)use($xml){
            $xml->addChild($key, $value);
        });
        return $xml;
    }
}
