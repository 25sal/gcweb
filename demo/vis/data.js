
window.dhx4.skin = 'dhx_web';
var main_layout = new dhtmlXLayoutObject(document.body, '2U');

var cell_a = main_layout.cells('a');
cell_a.setWidth('400');
cell_a.fixSize(1,0);
cell_a.setText(' ');
cell_a.hideHeader();
var treeview_1 = cell_a.attachTreeView();
treeview_1.loadStruct('../data/simfiles.xml');

treeview_1.attachEvent('onSelect', function(id, state){
    var nodetype=treeview_1.getUserData(id, "filename");
    b.attachURL('./viewfile.php?filename='+nodetype);
});

var b = main_layout.cells('b');
b.hideHeader();
b.attachURL('./viewfile.php');
