# معلومات عنه #

هذي النسخه خاصة بالمبرمج بلاك كات ولا يصح استخدامه دون موافقة المبرمج ولا يصح ازالة الحقوق به

### كيف أضف اداة ###

 * من خلال interfaces example : class ClassNameTool implements Tools
 * الخطوه الثانية أضافة أسم الاداة example : public $title = "NameTool";
 * و أضافة المتغيرين المهمين :     public $instance; public $Methods;
 * $instance هو اوبجيت كلاس و $Methods هو قائمة الميثود الموجوده فيه
 * تحتاج تضيف ميثود BuilderMethods من اجل بناء قائمة الميثودات وهو كتالي
 ```php
	public function BuilderMethods()
    {
        $this->instance = $this;
        $methods = get_class_methods($this);
        $array = array();
        foreach($methods as $method){ $array += [$method => $method]; }
        return $array;
    }
```
* و أيضاً ميثود بناء الاداة كinstance array.

```php
    public function Base()
    {
        $this->Methods = $this->BuilderMethods();
        $array = array('instance' => $this->instance , 'Methods' =>  $this->Methods);
        return $array;
    }
```
