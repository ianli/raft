RAFT Ain't For Templating
=========================

RAFT is a simple implementation for templates.
It takes advantage of the fact that PHP, in itself,
is already a good templating system.
Building a big templating system on top of it is too much overhead.


How RAFT Works
--------------

### Creating a template

The user creates a layout in PHP by including raft.php
and using the raft function.
For example, here's a layout file (layout.php):

```php
<html>
<head>
  <title><?php echo raft("title"); ?></title>
</head>
<body>
  <h1><?= raft("title"); ?></h1>
  
  <?php raft("content"); ?>
  
  <footer>
    <?= raft("footer"); ?>
  </footer>
</body>
</html>
```

### Assigning RAFT values

There are several ways to create RAFT values.
In the following examples, we create a RAFT value for "title".

**Method 1**

Assign a value to the associated array variable `$raft`.

```php
$raft["title"] = "Hello World!";
```

**Method 2**

Create a method prefixed with `raft_` that returns a value.

```php
function raft_title() {
	return "Hello World!";
}
```

**Method 3: Self-printing RAFT value**

Create a method prefixed with `raft_`, but print the value instead of returning it.

```php
function raft_title() {
	echo "Hello World!";
}
```

**Method 4: rafting(key, value, ...)**

Use the rafting(key, value, ...) function. The nice thing about this function is you can pass a variable number of value parameters, which are then concatenated together.

```php
rafting("title", "Hello ", "World", "!");
```

**Method 5: rafting(key) ... end_rafting(key)**

There's a second way to use the rafting function. If you only pass a key to rafting, you can use it in conjunction with end_rafting. Any output that occurs between rafting and end_rafting becomes assigned to the RAFT value.

```php
<?php rafting("title"); ?>
	Hello World!
	<?= "I'm feeling great!" ?>
<?php end_rafting("title")?>
```


### Example

The user creates a content page; again, in PHP.
   
```php
<?php
  include_once("php/raft.php");
  
  $raft["title"] = "My Web Page.";

  function raft_content() {
    echo "Hello World!";
  }
  
  rafting("footer");
  
  echo "This is the footer";
  
  end_rafting("footer");

  include("layout.php");
?>
```


Versioning
----------

For transparency and insight into our release cycle, and for striving to maintain backwards compatibility, this code will be maintained under the Semantic Versioning guidelines as much as possible.

Releases will be numbered with the follow format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

* Breaking backwards compatibility bumps the major
* New additions without breaking backwards compatibility bumps the minor
* Bug fixes and misc changes bump the patch

For more information on SemVer, please visit http://semver.org/.


Versions
--------

**0.4.2**	- 2010-11-17

- Added rafting and end_rafting.
- Added variable parameters to rafting which are appended to the raft.
- Removed begin_raft and end_raft.

**0.4.1** -	2010-11-17

- If the same id is used for begin_raft, the buffered content is appended.
- Added begin_raft and end_raft.
- Create $raft variable if it hasn't been set, so we don't have to check whether it exists.

**0.3.0** - 2010-11-11

- Added check whether $raft is set before checking whether it has a key.

**0.2.0** - 2010-11-09

- raft function always returns a value.

**0.1.0** - 2010-11-08

- Started implementation.


License
-------

Copyright 2010 Ian Li, http://ianli.com

Licensed under [the MIT license](http://www.opensource.org/licenses/mit-license.php).