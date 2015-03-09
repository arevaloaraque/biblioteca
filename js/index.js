/* Movimiento de la barra de titulo */
var repeat = 1; //enter 0 to not repeat scrolling after 1 run, othersise, enter 1 
var title  = document.title ;
var leng   = title.length;
var start  = 1 ;
var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

function titlemove() { 
	titl = title.substring(start, leng) + title.substring(0, start) 
	document.title = titl 
	start++ 
	if (start==leng+1) { 
		start=0 
		if (repeat==0) 
			return 
	} 
	setTimeout("titlemove()",340) 
} 

if (document.title) 
	titlemove()
/* FIN Movimiento de la barra de titulo */
