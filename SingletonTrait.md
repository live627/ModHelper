---
layout: recipe
title: SingletonTrait
---

# SingletonTrait

A quick way to turn any class into a singleton using this trait.

{% highlight php linenos startinline %}
class A {
    use Singleton;

    protected function init() {
        $this->foo = 1;
        echo "Hi!\n";
    }
}

var_dump(A::getInstance());

new A();
{% endhighlight %}

The expected output is:

```
Hi!
object(A)#1 (1) {
  ["foo"]=>
  int(1)
}
```
and the new fails:
```
Fatal error: Call to private A::__construct() from invalid context in ...
```
