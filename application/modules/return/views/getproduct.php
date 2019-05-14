<?php
//echo $_GET['type'];
$con1=$_GET['con'];
$con2=explode("^",$con1);
$con3=$con2[0];
$Productctg_id=$con2[1];

?>
<!DOCTYPE html>
<html lang="en">
<head>

<script type="text/javascript">

var x = document.getElementsByClassName("prds");
function ChangeCurrentCell() 
{

}

    ChangeCurrentCell();

    $(document).keydown(function(e){

        if (e.keyCode == 37) 
        { 

           currentCell--;

		  // alert(currentCell);

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


		function abc(pt,pr,tid,q,u,t)
		{
		  				
			var pid=pt.split("^");
			var pids=pid[1];
			var pidd=pid[0];


			//alert(q);
			/*var cuisines = ['Chinese','Indian'];     

			var sel = document.getElementById('CuisineList');

			for(var i = 0; i < cuisines.length; i++) {
			var opt = document.createElement('option');
			opt.innerHTML = cuisines[i];
			opt.value = cuisines[i];
			sel.appendChild(opt);
			}

			*/
			//getMake(pids);
			document.getElementById("pri_id").value=pids;
		    document.getElementById("prd").value=pidd;			
			document.getElementById("qn").value="";			
			//document.getElementById("prd").value=pidd;
			//document.getElementById("lpr").innerHTML=pr;
			//document.getElementById("price").value=pr;
			document.getElementById("spid").value=tid;
			document.getElementById("usunit").value=u;
			document.getElementById("quantity").value=q;					
			document.getElementById("type").value=t;
			
		}

function getMake1(pids)
{

	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", "getMakeFun?con="+pids, false);
	xhttp.send();
	document.getElementById("make").innerHTML = xhttp.responseText;

}

  </script>
</head>
<body>
<?php

if($con1!="")
{

$sel=$this->db->query("select * from tbl_product_stock where supp_name='".$_GET['vendor_id']."' AND productname like '%$con1%'");

$i=0;

foreach($sel->result() as $arr)
{

	$usageunit=$arr->usageunit;
	$qty=$arr->quantity;
	$mk=$arr->make1;

	$product_det1 = $this->db->query("Select * from tbl_master_data where serial_number= '$arr->usageunit'");

	$prod_Details1 = $product_det1->row();

	$usunit=$prod_Details1->keyvalue;		

	$i++;
	$id='d'; 

	$id.=$i; 
	$countid+= count($id);
	//echo $arr->size;
	$sqlunit=$this->db->query("select * from tbl_master_data where serial_number='$arr->size'");
	$fetchsize=$sqlunit->row();						

	//$dataNew=implode(" ", $data);

	//print_r($data)
?>

<input type="text" id="ty<?php echo $id;?>"  class="prds form-control" value="<?php echo $arr->productname.'' ?>^<?php echo $arr->sku_no;//$arr->Product_id; ?>" name="<?php echo $id;?>"
 onFocus="abc(this.value,'<?php echo $arr->unitprice_purchase; ?>',this.id,'<?php echo $qty; ?>','<?php echo $usunit; ?>','<?php echo $arr->via_type; ?>')"
 onClick="abc(this.value,'<?php echo $arr->unitprice_purchase; ?>',this.id,'<?php echo $qty; ?>','<?php echo $usunit; ?>','<?php echo $arr->via_type; ?>')" style="width:240px;border:1px solid;" tabindex="-1"  readonly >


<?php
 
 }

}

?>
<input type="hidden" value="<?php echo $i;?>" id="ttsp" >
<input type="hidden" id="countid" value="<?php echo $countid;?>">
</body>
</html>