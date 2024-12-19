const screenWidth = window.screen.width;
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('start_stop').innerHTML = html_start;
  //list_work_day();
  // let code1 = "22G3";
  // let code2 = "22GH";
  // let fecha_start = "2024-12-01";
  // let fecha_fin = "2024-12-31";

  btn_salida.setAttribute("disabled", true);
  start_stop.setAttribute("disabled", true);
  var dataGrid = {};
  //configurmaos estado de los bottones
  set_status_from_db();
  // cargamos el data grid
  load_grid();

});
const load_grid = function(){
  const screenWidth = window.screen.width;
  //$("#datagrid").empty();
  if(screenWidth < 600){
    load_grid_data_movile();
  } else {
    load_grid_data();
  }
}
const update_grid = function(){
  const screenWidth = window.screen.width;

  //$("#datagrid").empty();
  if(screenWidth < 600){
    dataGrid.updateConfig({
      data: fn_data_grid_movil
    }).forceRender();
  } else {
    dataGrid.updateConfig({
      data: fn_data_grid
    }).forceRender();
  }
}
const load_grid_data = function(){
  const screenWidth = window.screen.width;
  dataGrid = $("div#datagrid").Grid({
    columns: [
      {
        name: 'Usuario',
        width: '120px'
      },
      {
        name: 'Ip',
        width: '350px',
        hidden: screenWidth < 600 ? true : false,
        attributes: (cell) => {
          // add these attributes to the td elements only
          if (cell) {
            let style = '';
            if(screenWidth < 600){
              style += '; visibility: hidden'
            }
            return {
              'data-cell-content': cell.props.content.replace(/<\/?[^>]+(>|$)/g, ""),
              //'onclick': () => alert(cell.props.content.replace(/<\/?[^>]+(>|$)/g, "")),
              'style': style,
            };
          }
        }
      }, {
        name: 'Dia',
        width: '150px'
      },
      {
        name: 'Comentario',
        hidden: screenWidth < 600 ? true : false,
        width: '90px'
      }, {
        name: 'Rango de horas',
        //width: "350px",
        attributes: (cell) => {
          // add these attributes to the td elements only
          if (cell) {
            let style = 'max-width: 450px;';
            //console.log($(cell))
            return {
              'data-cell-content': cell.props.content.replace(/<\/?[^>]+(>|$)/g, ""),
              //'onclick': () => alert(cell.props.content.replace(/<\/?[^>]+(>|$)/g, "")),
              'style': style,
            };
          }
        }

      }, {
        name: "Total Horas",
        width: "130px",
        hidden: screenWidth < 600 ? true : false,
      }],
    data: fn_data_grid
  })
}
const load_grid_data_movile = function(){
  const screenWidth = window.screen.width;
  dataGrid = $("div#datagrid").Grid({
    columns: [
      {
        name: 'Jornada',
        width: '100%',
        //hidden: screenWidth < 600 ? true : false,
        attributes: (cell) => {
          //console.log("attributes", cell)
          let style = "user-select: text;";
          // add these attributes to the td elements only
          if (cell) {
            return {
              'data-cell-content': cell.props.content.replace(/<\/?[^>]+(>|$)/g, ""),
              //'onclick': () => alert(cell.props.content.replace(/<\/?[^>]+(>|$)/g, "")),
              'style': style,
            };
          }
        }


      }],
    data: fn_data_grid_movil
  })
}
/*
traemos datos desde el servidor para la version desktop
*/
const fn_data_grid = function(){
  return new Promise(async function(resolve) {
    let data =  await list_work_day();
    let last_element = data.datas.pop();

    let total_working = sum_horas_fun(last_element.sum_horas.hor, last_element.sum_horas.min, last_element.sum_horas.sec);//last_element.sum_horas.hor + ":" + last_element.sum_horas.min + ":" + last_element.sum_horas.sec;
    let total_working_day = checkDecimal(total_working.hor) + ":" + checkDecimal(total_working.min) +":" + checkDecimal(total_working.sec);
    //console.log("total_working_day", total_working_day);
    let list_working_day = data.datas.map(work => {
      let div = document.createElement('div');
      div.innerHTML = work.horas;
      div.classList = "horas-container";
      div.style.whiteSpace = "break-spaces";

      let div_ips = document.createElement('div');
      div_ips.innerHTML = work.ips.replaceAll(",", "<br>");

      return [user_arr[work.administrators_id], div_ips, work.dia, work.comment, div, work.tiempo_trabajado]
    })
    let div_horas = document.createElement('div');
    div_horas.innerHTML = last_element.horas;

    list_working_day.push(['', '', '', '', div_horas, total_working_day]);
    resolve(
      list_working_day
    )

  })
}
/**
 *
 * @returns traemos datos para la version mobile
 */
const fn_data_grid_movil = function(){

  return new Promise(async function(resolve) {
    let data =  await list_work_day();
    let last_element = data.datas.pop();

    //console.log("2 " + JSON.stringify(data));

    let total_working = sum_horas_fun(last_element.sum_horas.hor, last_element.sum_horas.min, last_element.sum_horas.sec);//last_element.sum_horas.hor + ":" + last_element.sum_horas.min + ":" + last_element.sum_horas.sec;
    let total_working_day = checkDecimal(total_working.hor) + ":" + checkDecimal(total_working.min) +":" + checkDecimal(total_working.sec);

    let list_working_day = data.datas.map(work => {
      let horas = work.horas.replaceAll(",", "<br>");
      let div = document.createElement('div');
      div.innerHTML = "<b>Usuario</b>: " + user_arr[work.administrators_id] + "<br><b>Día</b>: "+work.dia+"<br><b>Rango de horas:</b><br>" + horas + "<br><b>Total horas</b><br>" +work.tiempo_trabajado;

      //let display_work = "Id: " + work.administrators_id + "\x0A" + "Rango de horas: \x0A" + work.horas;
      return [div];
    }/*[work.administrators_id, work.ips, work.dia, work.comment, work.horas]*/)
    let div_horas = document.createElement('div');
    div_horas.innerHTML = `<b>Total horas: </b><br>${total_working_day}`;

    list_working_day.push([div_horas]);

    resolve(
      list_working_day
    )


   })
}

/////////////////////////////////////////////
// click sobre el boton start_stop
/////////////////////////////////////////////
start_stop.addEventListener("click", (e) => {

  const overlay = document.getElementById('popup_alert');
  // Mostrar el cuadro
  overlay.classList.add('show');
  //console.log("timerRuning",timerRuning);
  if(timerRuning){
    //console.log("Paramos periodo");
    init_fin_periodo("stop");
  } else {
    //console.log("Iniciamos periodo");
    init_fin_periodo("start");
  }
  var texto = start_stop.querySelector("i").getAttribute("txt-btn");
  // console.log(texto);
  if(texto == "stop"){
      // llamar a la function que apunte el fin de periodo
      stop();
      btn_entrada.setAttribute("disabled", true);
      btn_salida.removeAttribute("disabled");
      btn_start()
  } else {
      // llamar a la function que apunte el inicio de periodo
      start();
      btn_entrada.setAttribute("disabled", true);
      btn_stop();
  }
  //console.log($("#start_stop i").attr("txt-btn"));
});
////////
// click sobre startTime///
///////////////////////////////

btn_entrada.addEventListener('click', () => {
  //console.log('Click Entrada1');
  const overlay = document.getElementById('popup_alert');
  // Mostrar el cuadro
  overlay.classList.add('show');

  btn_entrada.setAttribute('disabled', true);
  btn_salida.removeAttribute('disabled');
  start_stop.innerHTML = html_stop;
  start_stop.removeAttribute('disabled');
  start();
  save_date('entrada');
});
/////
// click sobre el boton salida////
//////////////////////////////////

btn_salida.addEventListener('click', () => {
  //console.log('Click Salida1');
  const overlay = document.getElementById('popup_alert');
  // Mostrar el cuadro
  overlay.classList.add('show');
  btn_salida.setAttribute('disabled', true);
  btn_entrada.removeAttribute('disabled');
  start_stop.innerHTML = html_start;
  stop();
  save_date('salida');

});

// click on Buscar button

$('#search').click(function(){
  update_grid();
});