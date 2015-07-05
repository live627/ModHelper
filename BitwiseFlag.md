---
layout: default
title: BitwiseFlag
---

An abstract base class which will hold a single integer variable called $flags. This simple integer can hold 32 TRUE or FALSE boolean values. Another thing to consider is to just set certain BIT values without disturbing any of the other BITS. 

Note: these functions are protected to prevent outside code from falsely setting BITS.

```
setFlag($flag, $value) 
```
Will set a chosen bit

`$flag` The specific flag to store

The class is abstract and cannot be instantiated, so an extension is required. Below is a simple extension called User.

{% highlight php startinline %}
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

This seems like a lot of work, but we have addressed many issues, for example, using and maintaining the code is easy, and the getting and setting of flag values make sense. With the User class, you can now see how easy and intuitive bitwise flag operations become.

{% highlight php startinline %}
$user = new User();
$user->setRegistered(true);
$user->setActive(true);
$user->setMember(true);
$user->setAdmin(true);

echo $user;  // outputs: User [REGISTERED ACTIVE MEMBER ADMIN]
{% endhighlight %}
