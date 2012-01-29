RAFT Ain't For Templating
=========================

RAFT is a simple implementation for templates.
It takes advantage of the fact that PHP, in itself,
is already a good templating system.
Building a big templating system on top of it is too much overhead.

Here's how RAFT works:

1. The user creates a layout in PHP by including raft.php
   and using the raft function.
   For example, here's a layout file (layout.php):

    ```php
    <?php include_once("raft.php"); ?>
    <html>
    <head>
      <title><?php echo raft("title"); ?></title>
    </head>
    <body>
      <?php raft("content"); ?>
    </body>
    </html>
    ```

2. The user creates a content page; again, in PHP.
   The user assigns values to an associative array $raft.
   Or creates functions that start with "raft_".
   For example:
   
    ```php
    <?php
      $raft["title"] = "My Web Page.";

      function raft_content() {
        echo "Hello World!";
      }

      include("layout.php");
    ?>
    ```

3. **That's it!**


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

**0.3** - 2010-11-11

- Added check whether $raft is set before checking whether it has a key.

**0.2** - 2010-11-09

- raft function always returns a value.

**0.1** - 2010-11-08

- Started implementation.


License
-------

Copyright 2010 Ian Li, http://ianli.com

Licensed under [the MIT license](http://www.opensource.org/licenses/mit-license.php).