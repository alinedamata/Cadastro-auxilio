function check_form(){
  var inputs = document.getElementsByClassName('validar');
  var len = inputs.length;
  var valid = true;
  for(var i=0; i < len; i++){
    if (!inputs[i].value){ valid = false; }
  }
if (!valid){
  document.getElementById('loader').hidden = true
  swal("Atenção!", "Preencha todos os campos", "info") 
  return false;
} else { return true; }
}

$(document).ready(function(){
$('#form-create').on('submit', function(e) {  //Don't foget to change the id form
e.preventDefault(); //This is to Avoid Page Refresh and Fire the Event "Click"
document.getElementById('loader').hidden = false
const validForm = check_form();
if(!validForm){
  return
} else{
  jQuery.ajax({
    url  :"salvar.php",
    type :"POST",
    cache:false,
    contentType : false, // you can also use multipart/form-data replace of false
    processData : false,
    data: new FormData(this),
    success: () => {
        document.getElementById('loader').hidden = true
          swal("Sucesso!", "Cadastro realizado com sucesso!", "success").then(() => {
            document.getElementById("form-create").reset();
          })
    },
    error: (request, status, error) => {
      document.getElementById('loader').hidden = true
      mesagem_de_erro = null
      mesagem_de_erro = JSON.parse(request.responseText);
      swal("Atenção", `${mesagem_de_erro.mensagem}`, 'error')
    }
  });
}
});
});