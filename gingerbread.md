---
layout: default
title: Collection 
---

# Collection 

This is a class implementing IteratorAggregate using generator

{% highlight php linenos startinline %}
//Initializes a collection
$collection = new Collection();
$collection
        ->addValue('A string')
        ->addValue(new stdClass())
        ->addValue(NULL);

foreach ($collection as $item) {
    var_dump($item);
}
{% endhighlight %}
