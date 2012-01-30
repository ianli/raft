<html>
<head>
  <title></title>
  
  <!-- UTF-8 (Unicode) encoding -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <!-- HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.4.0/bootstrap.min.css" />
  
  <style>
    footer {
      text-align:center;
    }
  </style>
</head>
<body>

<div class="container" style="margin-top:20px">
  <div class="row">
    <div class="span16">
      
      <div class="hero-unit">
        <h1>RAFT Ain't For Templating</h1>
        <p>
          RAFT is simple templating for PHP.
          It strives for simplicity
          because building a big templating system is too much overhead.
          It takes advantage of the fact that PHP, in itself,
          is already a good templating system.
        </p>
      </div>
      
      <div class="row">
        <div class="offset1 span14">
      
          <h2>Assigning Values to a Key</h2>
      
          <table>
            <thead>
              <tr>
                <th>Key</th>
                <th>Value</th>
                <th>Code</th>
              </tr>
            </thead>
            <tr>
              <td>string</td>
              <td><?= raft('string') ?></td>
              <td>
                <pre>raft("string", "Assigned value to a string key.");</pre>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td><?= raft(2) ?></td>
              <td>
                <pre>raft(2, "Assigned value to a numeric key.");</pre>
              </td>
            </tr>
            <tr>
              <td>first.second.third</td>
              <td><?= raft("first.second.third") ?></td>
              <td>
                <pre>raft("first.second.third", "Assigned value to a nested key.");</pre>
              </td>
            </tr>
            <tr>
              <td>anonymous_function1</td>
              <td><?= raft('anonymous_function1') ?></td>
              <td>
<pre>raft("anonymous_function1", function() {
  echo "Used the output of an anonymous function.";
});</pre>
              </td>
            </tr>
            <tr>
              <td>anonymous_function2</td>
              <td><?= raft('anonymous_function2') ?></td>
              <td>
<pre>raft("anonymous_function2", function() {
  return "Used the return value of an anonymous function.";
});</pre>
              </td>
            </tr>
            <tr>
              <td>multiple_assignment1</td>
              <td><?= raft('multiple_assignment1') ?></td>
              <td rowspan="2">
<pre>raft(array(
  "multiple_assignment1" => "1st value of multiple assignment.",
  "multiple_assignment2" => "2nd value of multiple assignment."
));</pre>
              </td>
            </tr>
            <tr>
              <td>multiple_assignment2</td>
              <td><?= raft('multiple_assignment2') ?></td>
            </tr>
            <tr>
              <td>function1</td>
              <td><?= raft('function1') ?></td>
              <td>
<pre>function raft_function1() {
  echo "Used a function's output.";
}</pre>
              </td>
            </tr>
            <tr>
              <td>function2</td>
              <td><?= raft('function2') ?></td>
              <td>
<pre>function raft_function2() {
  return "Used a function that returns a value.";
}</pre>
              </td>
            </tr>
            <tr>
              <td>output_buffering</td>
              <td><?= raft('output_buffering') ?></td>
              <td>
<pre>raft("!BEGIN:output_buffering");
echo "Captured value using output buffering.";
raft("!END:output_buffering");</pre>
              </td>
            </tr>
            <tr>
              <td>ob.nested.key</td>
              <td><?= raft('ob.nested.key') ?></td>
              <td>
<pre>raft("!BEGIN:ob.nested.key");
echo "Captured value using output buffering with nested key";
raft("!END:ob.nested.key");</pre>
              </td>
            </tr>
          </table>
          
          
          <h2>Things to Keep in Mind</h2>
          
          <div class="row">
            <div class="span14">
              <h4>Format of keys is <code>/^\w+(\.\w+)*$/</code></h4>
            </div>
            <div class="span6">
              <p>
                In layman terms, this means your keys must consist of words
                separated by a dot (<code>.</code>).
                Words can only contain alphanumeric characters.
              </p>
            </div>
            <div class="span4">
<pre># CORRECT
variableName
Person_Name
1
</pre>
            </div>
            <div class="span4">
<pre># INCORRECT
variable-name
Person Name
!@#$%
</pre>
            </div>
            
            <div class="span14">
              <h4><code>!BEGIN</code> and <code>!END</code> must be used in pairs</h4>
            </div>
            
            <div class="span6">
              <p>
                Otherwise, untold havoc will ensue. You have been warned.
              </p>
            </div>
            <div class="span4">
<pre># CORRECT
raft("!BEGIN:sandwich");
echo "Bologna!";
raft("!END:sandwich");
</pre>
            </div>
            <div class="span4">
<pre># INCORRECT
raft("!BEGIN:sandwich");
echo "Bologna!";

# FIRE &amp; BRIMSTONE!
</pre>
            </div>
            
            <div class="span14">
              <h4>Keys next to <code>!BEGIN</code> and <code>!END</code> must match</h4>
            </div>

            <div class="span6">
              <p>
                Ditto.
              </p>
            </div>
            <div class="span4">
<pre># CORRECT
raft("!BEGIN:sandwich");
echo "Bologna!";
raft("!END:sandwich");
</pre>
            </div>
            <div class="span4">
<pre># INCORRECT
raft("!BEGIN:sandwich");
echo "Bologna!";
raft("!END:pita");

<?php

echo "# ";
try {
  raft("!BEGIN:sandwich");
  echo "Bologna!";
  raft("!END:pita");
} catch (Exception $e) {
  echo "\n# " . $e->getMessage();
}

?>
</pre>
            </div>
            
          </div>
            
        </div>
      </div>
      
      <footer>
        <p>
          This demo and documentation is generated by RAFT.
          <a href="http://github.com/ianli/raft/">Get the source code</a>.
        </p>
        <p>
          Copyright 2012 <a href="http://ianli.com">Ian Li</a>.
          Licensed under <a href="http://www.opensource.org/licenses/mit-license.php">the MIT License</a>.
        </p>
      </footer>
      
    </div>
  </div>
</div>



<!-- GitHub Ribbon -->
<a href="http://github.com/ianli/raft/"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://a248.e.akamai.net/assets.github.com/img/71eeaab9d563c2b3c590319b398dd35683265e85/687474703a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f677261795f3664366436642e706e67" alt="Fork me on GitHub"></a>
  
</body>
</html>