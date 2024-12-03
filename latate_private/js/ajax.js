//Seleccionamos todos los elementos que tengan esta clase, que serán los formularios que queremos enviar via ajax
const formularios_ajax = document.querySelectorAll(".FormularioAjax");


function enviar_formulario_ajax(e){
    e.preventDefault();

    // Confirmamos si queremos enviar el formulario antes de hacerlo
    let enviar = confirm("Do you want to send the form?");

    // Si confirmamos, procedemos con el envío del formulario
    if(enviar == true){

        //Variable con todos los valores de la formulario
        let data = new FormData(this);
        // Obtenemos el método y la acción del formulario
        let method = this.getAttribute("method");
        let action = this.getAttribute("action");

        // Agregamos los encabezados necesarios para el envío del formulario
        let encabezados = new Headers();

        // Definimos los encabezados necesarios para el envío del formulario
        let config = {
            method: method,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
            body: data
        };

        fetch(action, config)
        .then(respuesta => respuesta.text())
        .then(respuesta =>{ 
            let contenedor = document.querySelector(".form-rest");
            contenedor.innerHTML = respuesta;
        });
    }

}

// Determinamos que la función se aplique a cada formualrio que tenga esta clase
formularios_ajax.forEach(formulario => {
    formulario.addEventListener("submit", enviar_formulario_ajax);  // Agregamos un evento de submit a cada formulario
})