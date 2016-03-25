<?php

namespace ModHelper\Tests;

class YamlParserTest extends \PHPUnit_Framework_TestCase
{
    private $parser;

    protected function setUp()
    {
        $parser = new \ModHelper\YamlParser();
    }

    public function testArticleKeys()
    {
        $parsed = $this->parser->load(__DIR__ . '/files/article.yml');
        $actual = array_keys($parsed);
        $expected = array('author', 'category', 'article', 'articleCategory');

        $this->assertEquals($expected, $actual);
    }

    public function testArticle()
    {
        $parsed = $this->parser->load(__DIR__ . '/files/article.yml');
        $actual = $parsed['article'][0];
        $title = 'How to Use YAML in Your Next PHP Project';
        $content = 'YAML is a less-verbose data serialization format. '
                 . 'It stands for "YAML Ain\'t Markup Language". '
                 . 'YAML has been a popular data serialization format among '
                 . 'software developers mainly because it\'s human-readable.\n';

        $expected = array('id' => 1, 'title' => $title, 'content' => $content, 'author' => 1, 'status' => 2);

        $this->assertEquals($expected, $actual);

        var_export($this->parser);
    }

    /**
     * @expectedException \ModHelper\Exceptions\YamlParserException
     */
    public function testException()
    {
        $this->parser->load(__DIR__ . '/files/wrong-syntax.yml');
    }
}
