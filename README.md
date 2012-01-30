RAFT Ain't For Templating
=========================

RAFT is simple templating for PHP. 
It strives for simplicity because building a big templating system 
is too much overhead. 
It takes advantage of the fact that PHP, in itself, is already a good templating system.


Demo
----

See a demo of RAFT at http://ianli.com/raft/


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

**1.0.0** - 2012-01-30

- Removed need for global variable `$raft`.
- All assignments and retrieval of values are done through the function `raft()`.
- Created `RAFT` class.
- Templating can be done with `raft()` or a `RAFT` object. `raft()` is shorter.
- Added support for nested keys, e.g., first.second.third
- Replaced `rafting` and `end_rafting` functions with `raft("!BEGIN:key")` and `raft("!END:key")`

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