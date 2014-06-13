<html>
<body>
<head>
  <title>JobPost</title>
  <link rel="stylesheet" href="tester.css">
    <script type="text/javascript">

      function activateTab(pageId) {
          var tabCtrl = document.getElementById('tabCtrl');
          var pageToActivate = document.getElementById(pageId);
          for (var i = 0; i < tabCtrl.childNodes.length; i++) {
              var node = tabCtrl.childNodes[i];
              if (node.nodeType == 1) { /* Element */
                  node.style.display = (node == pageToActivate) ? 'block' : 'none';
              }
          }
      }

    </script>
  </head>
  <body>
    <ul>
      <li>
        <a href="javascript:activateTab('page1')">Your Profile</a>
      </li>
      <li>
        <a href="javascript:activateTab('page2')">Your Postings</a>
      </li>
      <li>
        <a href="javascript:activateTab('page3')">Posting Candidates</a>
      </li>
      <li>
        <a href="javascript:activateTab('page4')">Offers Pedning</a>
      </li>
      <li>
        <a href="javascript:activateTab('page5')">Offers Accepted</a>
      </li>
    </ul>
    <div id="tabCtrl">
      <div id="page1" style="display: block;">Your Profile</div>
      <div id="page2" style="display: none;">Your Postings</div>
      <div id="page3" style="display: none;">Posting Candidates</div>
      <div id="page4" style="display: none;">Offers Pedning</div>
      <div id="page5" style="display: none;">Offers Accepted</div>
    </div>
  </body>
</html>