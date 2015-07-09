---
layout: default
title: Psr4AutoloaderClass
---

# Psr4AutoloaderClass

A general-purpose implementation that includes the optional
functionality of allowing multiple base directories for a single namespace
prefix.

{% highlight php linenos startinline %}
// instantiate the loader
$loader = new \Example\Psr4AutoloaderClass;

// register the autoloader
$loader->register();

// register the base directories for the namespace prefix
$loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/src');
$loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/tests');
{% endhighlight %}

The following line would cause the autoloader to attempt to load the
\Foo\Bar\Qux\Quux class from /path/to/packages/foo-bar/src/Qux/Quux.php:

{% highlight php linenos startinline %}
new \Foo\Bar\Qux\Quux;
{% endhighlight %}

The following line would cause the autoloader to attempt to load the 
\Foo\Bar\Qux\QuuxTest class from /path/to/packages/foo-bar/tests/Qux/QuuxTest.php:

{% highlight php linenos startinline %}
new \Foo\Bar\Qux\QuuxTest;
{% endhighlight %}
