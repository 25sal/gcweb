window.dhx4.skin = 'dhx_web';
var main_layout = new dhtmlXLayoutObject(document.body, '2U');

var cell_a = main_layout.cells('a');
cell_a.setWidth('400');
cell_a.fixSize(1,0);
cell_a.setText(' ');
cell_a.hideHeader();
tree = cell_a.attachTree();
tree.setImagePath("../codebase/imgs/dhxtreeview_web/");

        tree.setStdImages("spina.gif","cartella.gif","cartella.gif");
        tree.enableContextMenu(true);  //abilito menu per la treeview
        tree.attachEvent("onXLE", function(){
          // after loading ended and data rendered (before user's callback)
          // your code here
          tree.openAllItems(0);
      });
        tree.enableDragAndDrop(true);  //abilito drag and drop
      /*  tree.attachEvent("onRightClick", menu);  //collego rightclick alla funzione menu
        myContextMenu.attachEvent("onClick", additem);  //collego il click degli item del menu alla funzione additem
        myContextMenu.attachEvent("onClick", deleteitem);  //collego la funzione per l'eliminazione di un item selezionato
        myContextMenu.attachEvent("onClick", addproperties);
        */
        tree.load("../connector/tree_connector.php?simdir="+simdir,setIcon,'xml');

        dp = new dataProcessor("../connector/samples/tree/05_save_connector.php");
   
    
  dp.init(tree);
    //
    var cell_b = main_layout.cells('b');
   
    cell_b.hideHeader();
    cell_b.attachURL("chart.html");
function setIcon() {
}
