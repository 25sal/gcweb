<!DOCTYPE html>
<html>
<head>
  <title>Fancytree - Example: Glyph Extension / Bootstrap Theme</title>

  <meta http-equiv="content-type" content="text/html; charset=utf-8">
<!--
  <meta name="viewport" content="width=device-width, initial-scale=1">
-->
  <!--
  NOTE: "Bootstrap 3's JavaScript requires jQuery version 1.9.1 or higher, but lower than version 3"
  -->
  <script src="../js/lib/jquery-1.12.4.min.js"></script>
  <script src="../js/lib/jquery-ui.min.js"></script>

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/lib/bootstrap.min.js"></script>

  <link href="../src/skin-bootstrap/ui.fancytree.css" rel="stylesheet" class="skinswitcher">

  <script src="../src/jquery.fancytree.js"></script>
  <script src="../src/jquery.fancytree.dnd5.js"></script>
  <script src="../src/jquery.fancytree.edit.js"></script>
  <script src="../src/jquery.fancytree.glyph.js"></script>
  <script src="../src/jquery.fancytree.table.js"></script>
  <script src="../src/jquery.fancytree.wide.js"></script>
  <script src="../dhtmlx/codebase/dhtmlx.js"></script>

<!-- (Irrelevant source removed.) -->

<style type="text/css">
  /* Define custom width and alignment of table columns */
  #treetable {
    table-layout: fixed;
  }
  #treetable tr td:nth-of-type(1) {
    text-align: right;
  }
  #treetable tr td:nth-of-type(2) {
    text-align: center;
  }
  #treetable tr td:nth-of-type(3) {
    min-width: 100px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>


<!-- Add code to initialize the tree when the document is loaded: -->
<script type="text/javascript">
function opentab(url,simdir)
{
  parent.tabbar.addTab(simdir, simdir);
	var tab_search = parent.tabbar.cells(simdir);
	tab_search.setActive();
	tab_search.attachURL(url);

}


  var glyph_opts = {
      preset: "bootstrap3",
      map: {
      }
    };

  $(function(){
    // Initialize Fancytree
   

    $("#treetable").fancytree({
      extensions: ["dnd5", "edit", "glyph", "table"],
      checkbox: false,
      /*dnd5: {
        dragStart: function(node, data) { return true; },
        dragEnter: function(node, data) { return true; },
        dragDrop: function(node, data) { data.otherNode.copyTo(node, data.hitMode); }
        
      },*/
      glyph: glyph_opts,
      source: {url: "../data/sim_dir.xml", debugDelay: 1000},
      table: {
        checkboxColumnIdx: 1,
        nodeColumnIdx: 2
      },
      activate: function(event, data) {
      },
      /*lazyLoad: function(event, data) {
        data.result = {url: "ajax-sub2.json", debugDelay: 1000};
      },*/
      renderColumns: function(event, data) {
        var node = data.node,
          $tdList = $(node.tr).find(">td");
        $tdList.eq(0).text(node.getIndexHier());

        if( !isNaN(parseInt(node.title))) 
        {
          var sim_dir=node.parent.parent.title;
          var date=node.parent.title.substr(5);
          date=date.replace(/\//g,"_");
          var sim_ex = sim_dir+"/"+date+"_"+node.title;
          $tdList.eq(3).html('<a onclick=opentab("./vis/data.php?simulation='+sim_ex+'","'+sim_ex+'");  href=#>data</a>');
          $tdList.eq(4).html('<a onclick=opentab("./vis/chart.php?simulation='+sim_dir+'","'+sim_ex+'");  href=#>view</a>');
        }
          $tdList.eq(5).html('<a onclick="delete();"  href=#>delete</a>');

      }
    });
  });
</script>

<!-- (Irrelevant source removed.) -->

</head>

<body>
<h3> simulation Results </h3>
<!--
  <p id="bootstrapTableStyles">
    <b>Add table class:</b><br>
    <label><input type="checkbox" data-class="table-bordered"> table-bordered</label>
    <label><input type="checkbox" data-class="table-condensed" checked="checked"> table-condensed</label>
    <label><input type="checkbox" data-class="table-striped" checked="checked"> table-striped</label>
    <label><input type="checkbox" data-class="table-hover" checked="checked"> table-hover</label>
    <label><input type="checkbox" data-class="table-responsive"> table-responsive</label>
    <label><input type="checkbox" data-class="fancytree-colorize-selected"> fancytree-colorize-selected</label>
  </p>
-->
  <table id="treetable" class="table table-condensed table-hover table-striped fancytree-fade-expander">
    <colgroup>
      <col width="80px"></col>
      <col width="30px"></col>
      <col width="*"></col>
      <col width="100px"></col>
      <col width="100px"></col>
      <col width="100px"></col>
    </colgroup>
    <thead>
      <tr> <th></th> <th></th> <th>Simulation</th> <th>Raw Data</th> <th>Chart</th> <th></th> Delete</tr>
    </thead>
    <tbody>
      <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> </tr>
    </tbody>
  </table>


  <!-- (Irrelevant source removed.) -->
</body>
</html>
