// iniciar el cronometro
var start = function(){

  timerRuning = true;
  sec++;
  if(sec > 59){
    sec = 0;
    min++;
  }
  if(min > 59){
    min = 0;
    hr++;
  }
  if(hr > 12){
    hr = 0;
  }
  timer = setTimeout(function(){
    start();
  }, 1000);
  document.getElementById('clock').innerHTML = checkDecimal(hr) + " : " + checkDecimal(min) + " : " + checkDecimal(sec);
}
// paramos cronometro
var stop = function(){
  clearTimeout(timer);
  timerRuning = false
}
// comprobamos los decimales necesitamos 01 en vez de 1
var checkDecimal = function(elem){
  if(elem < 10){
     elem = elem.toString().padStart(2,"0");
   }
    return elem;
}
function btn_start(){
  start_stop.querySelector("i").classList.remove("fa-pause-circle");
  start_stop.querySelector("i").classList.add("fa-play-circle");
  start_stop.querySelector("i").setAttribute("txt-btn","start");
}
function btn_stop(){
  start_stop.querySelector("i").classList.remove("fa-play-circle");
  start_stop.querySelector("i").classList.add("fa-pause-circle");
  start_stop.querySelector("i").setAttribute("txt-btn","stop");
}


/////////////////////////////////////
// guardar inicio/fin de periodo
/////////////////////////////////////
const init_fin_periodo = (init_fin) => {
  const overlay = document.getElementById('popup_alert');
  //22G3,22GH,4H9Y
  let code1 = "22G3";
  let code2 = "22GH";
  let login_code = $("#login_code").val().split(",");
  setTimeout(function(){
    // Mostrar el cuadro
    overlay.classList.remove('show');
  }, 2000);

  if(login_code == ""){
    //alert("Salga de esta pagina y vya a login, para que todo vaya bien");
    window.location.href = url_logout;
    return
  }
  code1 = login_code[0];
  code2 = login_code[1];
  //return
  //console.log(url_base_api);
  fetch(url_api, {
    method: 'POST',  // Indicamos que es una solicitud POST
    headers: {
      'Content-Type': 'application/json'  // Especificamos que estamos enviando JSON
    },
    body: JSON.stringify({
      PostData:{
        action: 'save_initfin',
        crm_totals: "OK",
        period_init_fin: init_fin,
        code1: code1,
        code2: code2
      }
    })  // Convertimos el cuerpo a JSON
  })
  .then(response => response.json())  // Parseamos la respuesta a JSON
  .then(data => {
    //console.log(data)
    update_grid();

  })     // Mostramos los datos de la respuesta
  .catch(error => console.error('Error:', error));
}

// guardar datos en la tabla
const save_date = (sal_entr) => {
  //22G3,22GH,4H9Y
  let code1 = "22G3";
  let code2 = "22GH";
  let login_code = $("#login_code").val().split(",");
  if(login_code == ""){
    //alert("Salga de esta pagina y vya a login, para que todo vaya bien");
    window.location.href = url_logout;
    return
  }
  code1 = login_code[0];
  code2 = login_code[1];

  const overlay = document.getElementById('popup_alert');
  var date_now = formatDate(new Date());
  var date = document.getElementById('clock').innerText.replace(/\s/g, '');
  var date_actual = date_now + " "+ date;

  setTimeout(function(){
    // Mostrar el cuadro
    overlay.classList.remove('show');
  }, 2000);
  fetch(url_api, {
    method: 'POST',  // Indicamos que es una solicitud POST
    headers: {
      'Content-Type': 'application/json'  // Especificamos que estamos enviando JSON
    },
    body: JSON.stringify({
      PostData:{
        action: 'save_entrada',
        crm_totals: "OK",
        sal_entr: sal_entr,
        code1: code1,
        code2: code2
      }
    })  // Convertimos el cuerpo a JSON
  })
  .then(response => response.json())  // Parseamos la respuesta a JSON
  .then(data => {
    console.log(data)
    if(sal_entr == "salida"){
      document.getElementById('clock').innerText = "00 : 00 : 00";
      hr = 0;
      min = 0;
      sec = 0;
    }
    // Mostrar el cuadro
    overlay.classList.remove('show');
    update_grid();

  })     // Mostramos los datos de la respuesta
  .catch(error => console.error('Error:', error));

}

const list_work_day = async function(){
  //alert("list_work_day");
  let code1 = "22G3";
  let code2 = "22GH";
  let login_code = $("#login_code").val().split(",");
  if(login_code == ""){
    //alert("Salga de esta pagina y vya a login, para que todo vaya bien");
    window.location.href = url_logout;
    return
  }
  code1 = login_code[0];
  code2 = login_code[1];
  let fecha_start = picker.getStartDate().format("YYYY-MM-DD");//"2024-12-01";
  let fecha_fin = picker.getEndDate().format("YYYY-MM-DD");//"2024-12-31";
  //alert(url_base_api);
  let PostData = JSON.stringify({
    PostData:{
      action: 'list',
      code1: code1,
      code2: code2,
      fecha_start: fecha_start,
      fecha_fin: fecha_fin
    }
  });

  return await $.ajax({
    url: url_api + "?jtStartIndex=0&jtPageSize=10",
    type: 'POST',
    data: PostData,
    dataType: 'json',
    headers: {
      'X-Requested-With': 'XMLHttpRequest', // Encabezado para indicar que es AJAX
      "Access-Control-Allow-Origin":"*"
    },
  }).done(function(data) {

    return data;

  }).fail(function(jqXHR, textStatus, errorThrown) {
    console.log('fail:', jqXHR.responseText);
    $('#code_test').text(jqXHR.responseText);

  }).always(function(data_jqXHR, textStatus, jqXHR_errorThrown) {
    var dataResult, jqXHR, errorThrown;
    if (textStatus == 'success') {
      dataResult = data_jqXHR;
      jqXHR = jqXHR_errorThrown;
    } else {
      jqXHR = data_jqXHR;
      errorThrown = jqXHR_errorThrown;
    }
  });

}

const sum_horas_fun = function(hor, min, sec){
  if(sec > 59){
		if((sec % 60) > 0){
			min = min + parseInt(sec / 60);
			sec = sec % 60;
		} else {
      min = min + parseInt(sec / 60);
			sec = sec % 60;
    }
  }
  if(min > 59){
		if((min % 60) > 0){
			hor = hor + parseInt(min / 60);
			min = min % 60;
		} else{
      hor = hor + parseInt(min / 60);
			min = min % 60;
    }

  }
	return {"hor":hor,"min":min,"sec":sec};
}

const set_cron_from_db = function(){
  ///////////////////////////////////////////
  var tiempo_ant = [];
  var btn_fin = false;
  //console.log("history_day",history_day);
  $.each(today_work, function(i,item){
    //console.log("fechas_fin_item",item);
    if(item.date_fin == null) {
      //console.log("NO existe");
      btn_fin = true;
    }
    tiempo_ant.push(calcula_tiempo_milisec(item.date_ini, (item.date_fin == null)?'': item.date_fin));
  });
  //console.log("tiempo_ant",tiempo_ant);
  var sum_hr = 0;
  var sum_min = 0;
  var sum_sec = 0;
  $.each(tiempo_ant,function(i,val){
    sum_hr += val.hr;
    sum_min += val.min;
    sum_sec += val.sec;
  });
  //console.log("SUMA_TIEMPO_BD",sum_hr, sum_min, sum_sec);
  var tiempo_suma = {"hr": sum_hr,"min": sum_min,"sec": sum_sec};
  //console.log("tiempo_suma",tiempo_suma);
  set_tiempo(tiempo_suma);
  return btn_fin;
}

const set_status_from_db = function(){
  var btn_fin = false;
  //console.log("history_day.length",history_day.length);
  if( today_work.length == 0 ){   // entra cuando no tengo nada apuntado en el dia
    $('#entrada').attr("disabled", false);
    $('#salida').attr("disabled",true);
    btn_start();
  } else { // entra cuando tengo periodo jornada cerrad una sola inesercion o sin cerrar

    //console.log("set_cron_from_db_1");
    btn_fin = set_cron_from_db();
    if(btn_fin){
      $('#entrada').attr("disabled", true);
      $('#salida').attr("disabled",false);
      btn_stop();

      start();
    } else {
      $('#entrada').attr("disabled", false);
      $('#salida').attr("disabled",true);
      btn_start();
    }
    if($('#start_stop i').attr("txt-btn") == 'start'){
      $('#salida').attr("disabled", false);
    } else {
      $('#entrada').attr("disabled", true);
      $('#salida').attr("disabled", false);
    }
    //console.log("start_work_day",start_work_day)
    if(start_work_day == 1){
      $('#entrada').attr('disabled', true);
      $('#start_stop').attr('disabled', false);
      document.getElementById('clock').innerHTML = checkDecimal(hr) + " : " + checkDecimal(min) + " : " + checkDecimal(sec);
    } else {
      $('#start_stop').attr('disabled', true);
      document.getElementById('clock').innerHTML = checkDecimal(0) + " : " + checkDecimal(0) + " : " + checkDecimal(0);
    }
  }

}
const set_tiempo = function(tiempo){
  //console.log(tiempo)
  //console.log("set_tiempo",tiempo.hr, tiempo.min, tiempo.sec);
  hr = parseInt(tiempo.hr);
  min = parseInt(tiempo.min);
  sec = parseInt(tiempo.sec);

  if(sec > 59){
	var modsec = sec % 60;
	if(modsec > 0){
		min = min + Math.floor(sec/60);
		sec = modsec;
	} else {
		sec = sec - 60;
		min = min + 1;
	}
    //console.log("sec",sec, "min",min);
  }
  if(min > 59){
	var modmin = min % 60;
	if(modmin > 0){
		hr = hr + Math.floor(min/60);
		min = modmin;
	}  else {
		min = min - 60;
		hr = hr + 1;
	}
    //console.log("min", min, "hr",hr);
  }
}
const calcula_tiempo_milisec = function(fecha_ini, fecha_fin){
  //console.log("fecha_ini", fecha_ini, "fecha_fin",fecha_fin)
  if(fecha_fin == ""){
    fecha_fin = new_Date();//moment().format("YYYY-MM-DD HH:MM:SS");//new_Date();
  }
  var FECHA_fin = moment((fecha_fin))//(fecha_fin == "")?moment(fecha_fin):moment(fecha_bonita(fecha_fin));
  var FECHA_ini = moment((fecha_ini));
  //console.log(FECHA_ini, FECHA_fin)
  var duration = FECHA_fin.diff(FECHA_ini);
  //console.log("duration",duration);
  var duration_mili = moment.duration(duration, 'milliseconds');
  //console.log("moment",duration_mili);
  let hours = duration_mili._data.hours;
  let minutes = duration_mili._data.minutes;
  let seconds = duration_mili._data.seconds;

  return {'hr':hours,'min':minutes,'sec':seconds}
}
const new_Date = function(){
  let dd= new Date();
  let y = dd.getFullYear();
  let m = dd.getMonth() + 1;
  let d = dd.getDate();
  let se = dd.getSeconds();
  let mi = dd.getMinutes();
  let hr = dd.getHours();
  if(String(d).length < 2){
    d = `0${d}`;
  }
  if(String(m).length < 2){
    m = `0${m}`;
  }
  if(String(hr).length < 2){
    hr = `0${hr}`;
  }
  if(String(mi).length < 2){
    mi = `0${mi}`;
  }
  if(String(se).length < 2){
    se = `0${se}`;
  }
  let fecha = y + "-" + m + "-" + d + " " + hr + ":" + mi + ":" + se;
  //console.log("FN_FECHA",fecha);
  return fecha;
}