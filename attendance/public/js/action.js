$('document').ready(function(){
	//alert("tested");
	//image select and show scripts
	$(document).on("change","#InputFile",function(e){
		e.preventDefault();
		showImages(this);
	});
	function showImages(input){
		if(input.files && input.files[0]){
			var imagetype = input.files[0].type;
			var imageExt = ["image/jpeg","image/png","image/gif"];
			if(!((imagetype==imageExt[0]) || (imagetype==imageExt[1]) || (imagetype==imageExt[2]) )){
			 alert("File is not a valid Image");
			}else{
				var reader = new FileReader();
				reader.onload = function(e){
					$("#imgs").attr("src",e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
		  }
							
		}
						
  }
	
		
	//Admin Login Script
	$(document).on("submit","#adminlogin", function(e){
		e.preventDefault();
		//alert("tested");
		$.ajax({
			url: 'admin/adminlogin.php',
			type: 'POST',
			contentType: false,
			processData: false,
			cache: false,
			data: new FormData(this),
			success: function(data){
			   if(data.match("success")){
				 alert("User Login Successfully");
				 window.location.href="admin/adminpage.php";
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	//Add Admin Script
	$(document).on("submit","#addadmin", function(e){
		e.preventDefault();
		//alert("tested");
		$.ajax({
			url: 'addadminscript.php',
			type: 'POST',
			contentType: false,
			processData: false,
			cache: false,
			data: new FormData(this),
			success: function(data){
			   if(data.match("success")){
				 alert("User Added Successfully");
				 window.location.href="addadmin.php";
			   }else if(data.match("Failed")){
				 alert("Something Went Wrong, Please Try again");
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	//Delect Admin Script
	$(document).on("click",".deladmin", function(e){
		e.preventDefault();
		//alert("tested");
		var cid = $(this).attr("cid");
		if(confirm("Are you sure you want to delect this user")){
			$.ajax({
				url: '../action.php',
				method: 'Post',
				data: {Deladmin: 1, cid: cid},
				success: function(data){
					if(data.match("sucess")){
						alert("User Delected Successfully");
						window.location.href="vusers.php";
					}else if("Failed"){
						alert("Failed to Delect User");
					}else{
						alert(data);
					}
				}
			});
		}		
	});
	
	//Add Programme Script
	$(document).on("submit","#addprog", function(e){
		e.preventDefault();
		//alert("tested");
		$.ajax({
			url: 'addProgrmmescript.php',
			type: 'POST',
			contentType: false,
			processData: false,
			cache: false,
			data: new FormData(this),
			success: function(data){
			   if(data.match("success")){
				 alert("Programme Added Successfully");
				 window.location.href="addProgrammes.php";
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	
	
	//Delect Programme Script
	$(document).on("click",".delprog", function(e){
		e.preventDefault();
		//alert("tested");
		var cid = $(this).attr("cid");
		if(confirm("Are you sure you want to delect this Programme")){
			$.ajax({
				url: '../action.php',
				method: 'Post',
				data: {DelProg: 1, cid: cid},
				success: function(data){
					if(data.match("sucess")){
						alert("Programme Delected Successfully");
						window.location.href="vDprogrammes.php";
					}else if("Failed"){
						alert("Failed to Delect Programme");
					}else{
						alert(data);
					}
				}
			});
		}		
	});
	
	//Delect Programme Script
	$(document).on("click",".delprog2", function(e){
		e.preventDefault();
		//alert("tested");
		var cid = $(this).attr("cid");
		if(confirm("Are you sure you want to delect this Programme")){
			$.ajax({
				url: '../action.php',
				method: 'Post',
				data: {DelProg: 1, cid: cid},
				success: function(data){
					if(data.match("sucess")){
						alert("Programme Delected Successfully");
						window.location.href="vDegprogrammes.php";
					}else if("Failed"){
						alert("Failed to Delect Programme");
					}else{
						alert(data);
					}
				}
			});
		}		
	});
	
	//Delect Programme Script
	$(document).on("click",".delprog3", function(e){
		e.preventDefault();
		//alert("tested");
		var cid = $(this).attr("cid");
		if(confirm("Are you sure you want to delect this Programme")){
			$.ajax({
				url: '../action.php',
				method: 'Post',
				data: {DelProg: 1, cid: cid},
				success: function(data){
					if(data.match("sucess")){
						alert("Programme Delected Successfully");
						window.location.href="allProgrammes.php";
					}else if("Failed"){
						alert("Failed to Delect Programme");
					}else{
						alert(data);
					}
				}
			});
		}		
	});
	
	
	//Add Programme Script
	$(document).on("submit","#addcost", function(e){
		e.preventDefault();
		//alert("tested");
		$.ajax({
			url: 'addCostcript.php',
			type: 'POST',
			contentType: false,
			processData: false,
			cache: false,
			data: new FormData(this),
			success: function(data){
			   if(data.match("success")){
				 alert("Programme Cost Added Successfully");
				 window.location.href="addmisionfrm.php";
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	
	
	//Delect admission form cost Script
	$(document).on("click",".delcost", function(e){
		e.preventDefault();
		//alert("tested");
		var cid = $(this).attr("cid");
		if(confirm("Are you sure you want to delect this Admission Form Cost")){
			$.ajax({
				url: '../action.php',
				method: 'Post',
				data: {DelCost: 1, cid: cid},
				success: function(data){
					if(data.match("sucess")){
						alert("Admission Cost Delected Successfully");
						window.location.href="addmisionfrm.php";
					}else if("Failed"){
						alert("Failed to Delect Admission Cost");
					}else{
						alert(data);
					}
				}
			});
		}		
	});
	
	
	//Purchase OSB CODE Script
	$(document).on("submit","#purchasecode", function(e){
		e.preventDefault();
		//alert("tested");
		$.ajax({
			url: 'osdcodesrcipt.php',
			type: 'POST',
			contentType: false,
			processData: false,
			cache: false,
			data: new FormData(this),
			success: function(data){
			   if(data.match("success")){
				   alert("Details Sent Successfully, Proceed to Payment")
				   $("#ipayModal").modal('show');		 
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	
	//Print Script
	$(document).on("click","#print", function(e){
		e.preventDefault();
		//alert("goooo");
		var mode = 'iframe'; // popup
        var close = mode == "popup";
        var options = { mode : mode, popClose : close};
        $("#printArea").printArea(options);		
	});
	
	
	//Purchase OSB CODE Script
	$(document).on("submit","#verifyosd", function(e){
		e.preventDefault();
		 //alert("tested");
		$.ajax({
			url: 'osdverifysrcipt.php',
			type: 'POST',
			contentType: false,
			processData: false,
			cache: false,
			data: new FormData(this),
			success: function(data){
			   if(data.match("success")){
				   alert("OSD Code Verified, Proceed")
				   window.location.href="onlineadmission.php";	 
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	
	
	//onlineadmission Form getdata Script
	$(document).on("submit","#personlinfo", function(e){
		e.preventDefault();
		//alert("tested");
		$.ajax({
			url: 'personlinfo.php',
			type: 'POST',
			contentType: false,
			processData: false,
			cache: false,
			data: new FormData(this),
			success: function(data){
			   if(data.match("success")){
				 alert("Personal Information Saved Successfully, Proceed");
				 window.location.href="admissionresults.php";
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	
	//admission results 1
	$(document).on("click","#saveresult1", function(e){
		e.preventDefault();
		var examstype = $("#extyp1").val();
		var examsyear = $("#exyr1").val();
		var indexnumber = $("#index1").val();
		var sub1 = $("#exsub1").val();
		var grad1 = $("#exgrade1").val();
		var sub2 = $("#exsub11").val();
		var grad2 = $("#exgrade11").val();
		var sub3 = $("#exsub12").val();
		var grad3 = $("#exgrade12").val();
		var sub4 = $("#exsub13").val();
		var grad4 = $("#exgrade13").val();
		var sub5 = $("#exsub14").val();
		var grad5 = $("#exgrade14").val();
		var sub6 = $("#exsub15").val();
		var grad6 = $("#exgrade15").val();
		
		if(examstype ==""){
			alert("Examination Type Cant Be Empty");
			return;
		}if(examsyear ==""){
			alert("Examination Year Cant Be Empty");
			return;
		}if(indexnumber ==""){
			alert("Index Number Cant Be Empty");
			return;
		}
		$.ajax({
			url: 'action.php',
			type: 'POST',
			data: {Result1: 1, examstype: examstype, examsyear: examsyear, indexnumber: indexnumber,
			sub1: sub1, grad1: grad1, sub2: sub2, grad2: grad2, sub3: sub3, grad3: grad3,
			sub4: sub4, grad4: grad4,sub5: sub5, grad5: grad5,sub6: sub6, grad6: grad6},
			success: function(data){
			   if(data.match("success")){
				 alert("Results 1 Saved Successfully");
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	
	//admission results 2
	$(document).on("click","#saveresult2", function(e){
		e.preventDefault();
		var examstype = $("#extyp2").val();
		var examsyear = $("#exyr2").val();
		var indexnumber = $("#index2").val();
		var sub1 = $("#exsub2").val();
		var grad1 = $("#exgrade2").val();
		var sub2 = $("#exsub21").val();
		var grad2 = $("#exgrade21").val();
		var sub3 = $("#exsub22").val();
		var grad3 = $("#exgrade22").val();
		var sub4 = $("#exsub23").val();
		var grad4 = $("#exgrade23").val();
		var sub5 = $("#exsub24").val();
		var grad5 = $("#exgrade24").val();
		var sub6 = $("#exsub25").val();
		var grad6 = $("#exgrade25").val();
		
		if(examstype ==""){
			alert("Examination Type Cant Be Empty");
			return;
		}if(examsyear ==""){
			alert("Examination Year Cant Be Empty");
			return;
		}if(indexnumber ==""){
			alert("Index Number Cant Be Empty");
			return;
		}
		$.ajax({
			url: 'action.php',
			type: 'POST',
			data: {Result2: 1, examstype: examstype, examsyear: examsyear, indexnumber: indexnumber,
			sub1: sub1, grad1: grad1, sub2: sub2, grad2: grad2, sub3: sub3, grad3: grad3,
			sub4: sub4, grad4: grad4,sub5: sub5, grad5: grad5,sub6: sub6, grad6: grad6},
			success: function(data){
			   if(data.match("success")){
				 alert("Results 2 Saved Successfully");
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	//admission results 3
	$(document).on("click","#saveresult3", function(e){
		e.preventDefault();
		var examstype = $("#extyp3").val();
		var examsyear = $("#exyr3").val();
		var indexnumber = $("#index3").val();
		var sub1 = $("#exsub3").val();
		var grad1 = $("#exgrade3").val();
		var sub2 = $("#exsub31").val();
		var grad2 = $("#exgrade31").val();
		var sub3 = $("#exsub32").val();
		var grad3 = $("#exgrade32").val();
		var sub4 = $("#exsub33").val();
		var grad4 = $("#exgrade33").val();
		var sub5 = $("#exsub34").val();
		var grad5 = $("#exgrade34").val();
		var sub6 = $("#exsub35").val();
		var grad6 = $("#exgrade35").val();
		
		if(examstype ==""){
			alert("Examination Type Cant Be Empty");
			return;
		}if(examsyear ==""){
			alert("Examination Year Cant Be Empty");
			return;
		}if(indexnumber ==""){
			alert("Index Number Cant Be Empty");
			return;
		}
		$.ajax({
			url: 'action.php',
			type: 'POST',
			data: {Result3: 1, examstype: examstype, examsyear: examsyear, indexnumber: indexnumber,
			sub1: sub1, grad1: grad1, sub2: sub2, grad2: grad2, sub3: sub3, grad3: grad3,
			sub4: sub4, grad4: grad4,sub5: sub5, grad5: grad5,sub6: sub6, grad6: grad6},
			success: function(data){
			   if(data.match("success")){
				 alert("Results 3 Saved Successfully");
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	
	//onlineadmission School Sttended Script
	$(document).on("submit","#schoolattended", function(e){
		e.preventDefault();
		//alert("tested");
		$.ajax({
			url: 'Schoolattended.php',
			type: 'POST',
			contentType: false,
			processData: false,
			cache: false,
			data: new FormData(this),
			success: function(data){
			   if(data.match("success")){
				 alert("Information Saved Successfully, Proceed");
				 window.location.href="admissionappinfo.php";
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	//onlineadmission School Sttended Script
	$(document).on("submit","#addchoice", function(e){
		e.preventDefault();
		//alert("tested");
		$.ajax({
			url: 'appinformation.php',
			type: 'POST',
			contentType: false,
			processData: false,
			cache: false,
			data: new FormData(this),
			success: function(data){
			   if(data.match("success")){
				 alert("Information Saved Successfully, Proceed");
				 window.location.href="admissiongurinfo.php";
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	//onlineadmission Guidian Information Script
	$(document).on("submit","#gurdianinfo", function(e){
		e.preventDefault();
		//alert("tested");
		$.ajax({
			url: 'gurdiancode.php',
			type: 'POST',
			contentType: false,
			processData: false,
			cache: false,
			data: new FormData(this),
			success: function(data){
			   if(data.match("success")){
				 alert("Information Saved Successfully, Proceed");
				 window.location.href="admissionsupdoc.php";
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	
	//onlineadmission Supporting Documents Script
	$(document).on("submit","#uploaddoc", function(e){
		e.preventDefault();
		//alert("tested");
		$.ajax({
			url: 'uploaddoc.php',
			type: 'POST',
			contentType: false,
			processData: false,
			cache: false,
			data: new FormData(this),
			success: function(data){
			   if(data.match("success")){
				 alert("Document Uploaded Successfully");
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	
	//onlineadmission Supporting Documents Script
	$(document).on("click",".deldocument", function(e){
		e.preventDefault();
		var cid = $(this).attr("cid");
		//alert(cid);
		$.ajax({
			url: 'action.php',
			type: 'POST',
			data: {Deldoc: 1, cid: cid},
			success: function(data){
			   if(data.match("success")){
				 alert("Document Delected Successfully");
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	
	//onlineadmission Supporting Documents Script
	$("#submitit").fadeOut(1000);
	$(document).on("submit","#uploadimg", function(e){
		e.preventDefault();
		//alert("tested");
		$.ajax({
			url: 'uploadprofileimg.php',
			type: 'POST',
			contentType: false,
			processData: false,
			cache: false,
			data: new FormData(this),
			success: function(data){
			   if(data.match("success")){
				 alert("Image Uploaded Successfully");
				 $("#hideimg").fadeOut(2000);
				 $("#submitit").fadeIn(2000);
			   }else{
				 alert(data);	
			   }
			}
		});
	});
	
	//submit application now
	$(document).on("click","#submitappnow", function(e){
		e.preventDefault();
		//alert("tested");
		if(confirm("Are You Sure You Want To Proceed!")){
			$.ajax({
				url: 'action.php',
				type: 'POST',
				data: {Submitapp: 1},
				success: function(data){
				   if(data.match("success")){
					 alert("Application Submitted Successfully");
					 window.location.href="admissioncomplete.php";
				   }else{
					 alert(data);	
				   }
				}
			});
		}
	});
	
	
	//Print application Summary
	$(document).on("click","#print_doc", function(e){
		e.preventDefault();
		alert("tested");
			/*$.ajax({
				url: 'action.php',
				type: 'POST',
				data: {Submitapp: 1},
				success: function(data){
				   if(data.match("success")){
					 alert("Application Submitted Successfully");
					 window.location.href="admissioncomplete.php";
				   }else{
					 alert(data);	
				   }
				}
			});*/
	});
	
	//Select year to view osd purchase information
	$(document).on("change","#typeofp", function(e){
		e.preventDefault();
		var year = $(this).val();
		//alert(year);
		$.ajax({
				url: '../action.php',
				type: 'POST',
				data: {Viewosdpurchase: 1, year: year},
				success: function(data){
				   $("#printArea").html(data);
				   //alert(data);
				}
			});
	});
	
	
	
});