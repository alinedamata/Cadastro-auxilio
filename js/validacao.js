const input = document.getElementById('cpf')

input?.addEventListener('keypress', () => {
    let inputLength = input.value.length

    // MAX LENGHT 14  CPF
    if (inputLength == 3 || inputLength == 7) {
        input.value += '.'
    } else if (inputLength == 11) {
        input.value += '-'
    }

})

function ApenasLetras(e, t) {
  try {
      if (window.event) {
          var charCode = window.event.keyCode;
      } else if (e) {
          var charCode = e.which;
      } else {
          return true;
      }
      if (
          (charCode > 64 && charCode < 91) || 
          (charCode > 96 && charCode < 123) ||
          (charCode > 191 && charCode <= 255) ||// letras com acentos
          (charCode == 32) 

      ){
          return true;
      } else {
          return false;
      }
  } catch (err) {
      alert(err.Description);
  }
}


