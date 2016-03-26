<?php

namespace ModHelper\Tests;

class SimpleXMLElementTest extends \PHPUnit_Framework_TestCase
{
    private $loader;

    protected function setUp()
    {
        $this->loader = new \ModHelper\SimpleXMLElement('<root/>');
    }

    public function testCData() {
        $this->loader->addChildWithCDATA('title', 'Site Title');
        $this->loader->addAttribute('lang', 'en');

        $this->assertEquals('<?xml version="1.0"?>
<root>
<title lang="en"><![CDATA[Site Title]]></title>
</root>', $this->loader->asXML());
    }

    public function testInstance() {
        $array = array(
            'hoi'
        );

        $this->loader->array2XML($array);

        $this->assertTrue($this->loader instanceOf \SimpleXMLElement);
    }

    public function testSimple() {

        $array = array(
            'name' => 'ardi',
            'last_name' => 'eshghi',
            'age' => 31,
            'tel' => '0785323435'
        );

        $expectedXmlEl = new \SimpleXMLElement('<root/>');
        $expectedXmlEl->addChild('name', $array['name']);
        $expectedXmlEl->addChild('last_name', $array['last_name']);
        $expectedXmlEl->addChild('age', $array['age']);
        $expectedXmlEl->addChild('tel', $array['tel']);

        $this->loader->array2XML($array);

        $this->assertEquals($expectedXmlEl->asXML(), $this->loader->asXML());
    }

    public function testList() {

        $array = array(
            'ardi',
            'eshghi',
            31,
            '0785323435'
        );

        $expectedXmlEl = new SimpleXMLElement('<root/>');
        foreach ($array as $key => $value)
            $expectedXmlEl->addChild('item', $value);

        $this->loader->array2XML($array);

        $this->assertEquals($expectedXmlEl->asXML(), $this->loader->asXML());
    }

    public function testComplex() {
        $testArray = array(
            'goal',
            'nice',
            'funny' => array(
                'name' => 'ardi',
                'tel' => '07415517499',
                'vary',
                'fields' => array(
                    'small',
                    'email' => 'ardi.eshghi@gmail.com'
                ),
                'good old days'
            ),

            'notes' => 'come on lads lets enjoy this',
            'cast' => array(
                'Tom Cruise',
                'Thomas Muller' => array('age' => 24)
            )
        );
        $this->loader->array2XML($testArray);

        $expectedXmlEl = new \SimpleXMLElement('<root/>');
        $expectedXmlEl->addChild('item', $testArray[0]);
        $expectedXmlEl->addChild('item', $testArray[1]);
        $childEl = $expectedXmlEl->addChild('funny');
        $childEl->addChild('name', $testArray['funny']['name']);
        $childEl->addChild('tel', $testArray['funny']['tel']);
        $childEl->addChild('item', 'vary');
        $childChildEl = $childEl->addChild('fields');
        $childChildEl->addChild('item', 'small');
        $childChildEl->addChild('email', $testArray['funny']['fields']['email']);
        $childEl->addChild('item', 'good old days');
        $expectedXmlEl->addChild('notes', $testArray['notes']);
        $childEl2 = $expectedXmlEl->addChild('cast');
        $childEl2->addChild('item', 'Tom Cruise');
        $childChildEl2 = $childEl2->addChild('Thomas Muller');
        $childChildEl2->addChild('age', $testArray['cast']['Thomas Muller']['age']);

        $this->assertEquals($expectedXmlEl->asXML(), $this->loader->asXML());
    }
}
