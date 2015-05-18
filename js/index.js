/* Movimiento de la barra de titulo */
var repeat = 1; //enter 0 to not repeat scrolling after 1 run, othersise, enter 1 
var title  = document.title ;
var leng   = title.length;
var start  = 1 ;
function valuesTitle() {
	repeat = 1; //enter 0 to not repeat scrolling after 1 run, othersise, enter 1 
	title  = document.title ;
	leng   = title.length;
	start  = 1 ;
}

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


/* Hora actual */
var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
var diaSem = {1:'Lunes',2:'Martes',3:'Miercoles',4:'Jueves',5:'Viernes',6:'Sabado',0:'Domingo'};
var mes    = {0:'Enero',1:'Febrero',2:'Marzo',3:'Abril',4:'Mayo',5:'Junio',6:'Julio',7:'Agosto',8:'Septiembre',9:'Octubre',10:'Noviembre',11:'Diciembre'};
function horaActual() {
	var date = new Date();
	var time = diaSem[date.getDay()] + ' ' + date.getDate() + ' de ' + mes[date.getMonth()] + ' del ' + date.getFullYear();
	return time;
}
/* FIN Hora actual */


/* Menu cerrado por defecto */
$('#ulRecursos .in').collapse('hide');
/* FIN Menu cerrado por defecto */