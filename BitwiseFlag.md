---
layout: default
title: BitwiseFlag
---

# BitwiseFlag

An abstract base class which will hold a single integer variable called $flags. This simple integer can hold 32 TRUE or FALSE boolean values. Another thing to consider is to just set certain BIT values without disturbing any of the other BITS. 

Note: these functions are protected to prevent outside code from falsely setting BITS.

```
setFlag($flag, $value) 
```
Will set a chosen bit

`$flag` The specific flag to store

The class is abstract and cannot be instantiated, so an extension is required. Below is a simple extension called User.

{% highlight php linenos startinline %}
class User extends BitwiseFlag
{
  const FLAG_REGISTERED = 1; // BIT #1 of $flags has the value 1
  const FLAG_ACTIVE = 2;     // BIT #2 of $flags has the value 2
  const FLAG_MEMBER = 4;     // BIT #3 of $flags has the value 4
  const FLAG_ADMIN = 8;      // BIT #4 of $flags has the value 8

  public function isRegistered(){
    return $this->isFlagSet(self::FLAG_REGISTERED);
  }

  public function isActive(){
    return $this->isFlagSet(self::FLAG_ACTIVE);
  }

  public function isMember(){
    return $this->isFlagSet(self::FLAG_MEMBER);
  }

  public function isAdmin(){
    return $this->isFlagSet(self::FLAG_ADMIN);
  }

  public function setRegistered($value){
    $this->setFlag(self::FLAG_REGISTERED, $value);
  }

  public function setActive($value){
    $this->setFlag(self::FLAG_ACTIVE, $value);
  }

  public function setMember($value){
    $this->setFlag(self::FLAG_MEMBER, $value);
  }

  public function setAdmin($value){
    $this->setFlag(self::FLAG_ADMIN, $value);
  }

  public function __toString(){
    return 'User [' .
      ($this->isRegistered() ? 'REGISTERED' : '') .
      ($this->isActive() ? ' ACTIVE' : '') .
      ($this->isMember() ? ' MEMBER' : '') .
      ($this->isAdmin() ? ' ADMIN' : '') .
    ']';
  }
}
{% endhighlight %}

###### Code obtained fron [a user contributed note on php.net](http://php.net/manual/en/language.operators.bitwise.php#108679)

This seems like a lot of work, but we have addressed many issues, for example, using and maintaining the code is easy, and the getting and setting of flag values make sense. With the User class, you can now see how easy and intuitive bitwise flag operations become.

{% highlight php linenos startinline %}
$user = new User();
$user->setRegistered(true);
$user->setActive(true);
$user->setMember(true);
$user->setAdmin(true);

echo $user;  // outputs: User [REGISTERED ACTIVE MEMBER ADMIN]
{% endhighlight %}

## A note about using hexadecimal numebers

Using hexadecimal numebers helps with the mental conversion between the integer value and the bit pattern it represents, which is the thing that matters for flags and masks.

Because 16 is a power of 2 (unlike 10), you get nice repeating things like this:

{% highlight php linenos startinline %}
const F0 = 0x1; // 2^0
const F1 = 0x2; // 2^1
const F2 = 0x4; // 2^2
const F3 = 0x8; // 2^3
const F4 = 0x10; // 2^4
const F5 = 0x20; // 2^5
const F6 = 0x40; // 2^6
const F7 = 0x80; // 2^7
// ...
const F20 = 0x1000000; // 2^20
const F21 = 0x2000000; // 2^21
const F22 = 0x4000000; // 2^22
const F23 = 0x8000000; // 2^23
const F24 = 0x10000000; // 2^24
// ... up to 2^31
{% endhighlight %}

See the pattern? You get neat groups of 1&ndash;8, and zero is appended to start a new group (leading zeros have been truncated for brevity and are optional).

In addition, hexadecimal constants indicate to the programmer that it's probably a bit mask, or a value that will be somehow involved in bitwise operations and should probably be treated specially.

Avoid using decimal notation, especially with a large amount of different flags, because it's very easy to misspell numbers like 2^20 (1048576).
