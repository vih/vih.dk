ns4 = document.layers
ie4 = document.all
nn6 = document.getElementById && !document.all

function hideObject() {
   if (ns4) {
      document.n1.visibility = "hide";
   }
   else if (ie4) {
      document.all['n1'].style.visibility = "hidden";
   }
   else if (nn6) {
      document.getElementById('n1').style.visibility = "hidden";
   }
}

// Show/Hide functions for pointer objects

function showObject(id) {
   if (ns4) {
      document.n1.visibility = "show";
   }
   else if (ie4) {
      document.all['n1'].style.visibility = "visible";
   }
   else if (nn6) {
      document.getElementById('n1').style.visibility = "visible";
   }
}

/*
</script>
<body>

<p>The space program is run by <a href="javascript:showObject();">NASA.</a>

<div id="n1" style="position:absolute;left:180; top:25;z-index:1;">
<table bgcolor="#ffff99" width=250 cellpadding=6 cellspacing=0 border=1 >
<tr>
<td>
   <p>The <b>N</b>ational <b>A</b>eronautics and <b>S</b>pace <b>A</b>ministration.</p>

   <a href="javascript:hideObject();">Close</a>
</td>
</tr>
</table>
</div>

*/