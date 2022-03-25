swal({
title: "Are you sure?",
text: "",
icon: "warning",
buttons: ['Cancel', 'Yes Assign'],
dangerMode: true,
})
.then((willDelete) => {
if (willDelete) {

$.ajax({

beforeSend: function(){
$.LoadingOverlay("show");
},
complete: function(){
$.LoadingOverlay("hide");
},

url: '{{}},
type: 'POST',
data: {},
success: function(data){ 

swal("Course Assigned Successfully, Reload Page to Take Effect",{
icon: 'success',
});

window.location.href=url;

},
error: function (data) {
console.log('Error:', data);
}
});  

}
});