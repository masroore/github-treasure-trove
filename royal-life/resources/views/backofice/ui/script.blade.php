<script >


function handleClickSuma() {
   let input = document.getElementById('cantidad');
   input.value = operacion('suma',input.value);
}
function handleClickResta() {
   let input = document.getElementById('cantidad');
   input.value = operacion('resta',input.value);
}

function  operacion(a,number) {

   if(a=== 'suma'){
    number++;
   }
   if(a === 'resta')
   {
       number--;
   }

   if(number < 1 || number === null){
    return number === 1;
   }

   return number;
}

function handleClickSuma1(e) {
   let input = document.getElementById(e);
   input.value = operacion('suma',input.value);
}
function handleClickResta1(e) {
   let input = document.getElementById(e);
   input.value = operacion('resta',input.value);
}

function  operacion(a,number) {

   if(a=== 'suma'){
    number++;
   }
   if(a === 'resta')
   {
       number--;
   }

   if(number < 1 || number === null){
    return number === 1;
   }

   return number;
}


</script>
