<?php
$con1=$_GET['search_id'];
$tableName=$_GET['tableName'];
$fieldName=$_GET['fieldName'];
$priId=$_GET['priId'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script>
 var x = document.getElementsByClassName("prds");
    function ChangeCurrentCell() {

    }

    ChangeCurrentCell();

    $(document).keydown(function(e){

        if (e.keyCode == 37) { 

           currentCell--;

		   alert(currentCell);

          // ChangeCurrentCell();

           return false;

        }

        if (e.keyCode == 39)

		 { 

           currentCell++;

         //  ChangeCurrentCell();

           return false;

        }
	

        if (e.keyCode == 38)

		 { 
 

		 if(currentCell>0)

		{

		currentCell--;

		//alert(currentCell);

		 x[currentCell].focus();

         x[currentCell].select();

		}

		else

		{

		var mx = document.getElementById("ttsp").value;

		currentCell=mx;


		 x[currentCell].focus();

         x[currentCell].select();

		 currentCell--;

		 //alert("Last...");

		}

		//  alert(currentCell);

              return false;

        }

		
        if (e.keyCode == 40) 

		{ 

		var mx = document.getElementById("ttsp").value;


		if(currentCell<mx)

		{

		 x[currentCell].focus();

         x[currentCell].select();

		currentCell++;

		 e.preventDefault();

		 e.stopPropagation();

		e.returnValue = false;

//Window.focus()

		 //break; 

		//alert(currentCell);

		}

		else

		{

		currentCell=0;

		 x[currentCell].focus();

         x[currentCell].select();

				//alert('rowCount'); 		          

	document.getElementById('prdsrch').scrollTop =0;

		}

		}

	    });


var xobj;

   //modern browers

   if(window.XMLHttpRequest)

    {

	  xobj=new XMLHttpRequest();

	  }
	  //for ie

    else if(window.ActiveXObject)

	   {
	    xobj=new ActiveXObject("Microsoft.XMLHTTP");
		}

		else

		{

	  alert("Your broweser doesnot support ajax");

		  }
         /*   function abc(pt,pr,tid,qs,lq)
		  {
	       		   document.getElementById("prd").value=pt;
					document.getElementById("qn").value=1;
					document.getElementById("lpr").innerHTML=pr;
					document.getElementById("lph").value=pr;
		//document.getElementById("spid").value=tid;
				/*if(qs<lq)
					{
					///alert('The city of ' + city + ' is located in ' + country + '.');
				alert(pt+ '- has Reached to Re-Order Level (' + lq + '). \n Please Re-Order...! ');
					}
			}*/


		  function abc(pt,pr,tid,q,u,quantity){
		  				
						var pid=pt.split("^");
		  				var pids=pid[1];
				
					document.getElementById("select_id").value=u;
				document.getElementById("search_id").value=pt;
					document.getElementById("qn").value=1;
					
					
					
		  }



  </script>
</head>
<body>
<?php

 if($con1!="")
 {

  $sel=$this->db->query("select $fieldName as fName,$priId as prId from $tableName where $fieldName like '%$con1%' and type='14' and via_type='23'");


  $i=0;

  foreach($sel->result() as $arr)
  {
  

?>

<input type="text" id="ty<?php echo $id;?>"  class="prds form-control"  value="<?php echo $arr->fName.'' ?>" name="<?php echo $id;?>"
 onFocus="abc(this.value,'<?php echo $arr->unitprice_purchase; ?>',this.id,'<?php echo $qty; ?>','<?php echo $arr->prId; ?>','<?php echo $arr->quantity; ?>')"
 onClick="abc(this.value,'<?php echo $arr->unitprice_purchase; ?>',this.id,'<?php echo $qty; ?>','<?php echo $arr->prId; ?>','<?php echo $arr->quantity; ?>')" style="width:240px;border:1px solid;" tabindex="-1"  readonly >


<?php

 }

}


?>
<input type="hidden" value="<?php echo $i;?>" id="ttsp" >
<input type="hidden" id="countid" value="<?php echo $countid;?>">
</body>
</html>