<?php

namespace ModHelper\Tests;

class YamlParserTest extends \PHPUnit_Framework_TestCase
{
    private $loader;

    protected function setUp()
    {
        $loader = new \ModHelper\YamlParser();
        $parsed = $this->loader->load(__DIR__ . '/files/article.yml');
    }

    public function testArticleKeys()
    {
        $actual = array_keys($parsed);
        $expected = array('author', 'category', 'article', 'articleCategory');

        $this->assertEquals($expected, $actual);
    }

    public function testArticle()
    {
        $actual = $parsed['article'][0];
        $title = 'How to Use YAML in Your Next PHP Project';
        $content = 'YAML is a less-verbose data serialization format. '
                 . 'It stands for "YAML Ain\'t Markup Language". '
                 . 'YAML has been a popular data serialization format among '
                 . 'software developers mainly because it\'s human-readable.\n';

        $expected = array('id' => 1, 'title' => $title, 'content' => $content, 'author' => 1, 'status' => 2);

        $this->assertEquals($expected, $actual);

        var_export($this->loader);
    }

    /**
     * @expectedException \ModHelper\Exceptions\YamlParserException
     */
    public function testException()
    {
        $this->loader->load(__DIR__ . '/files/wrong-syntax.yml');
    }
}
