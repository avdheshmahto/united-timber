<?php
//echo "hello";

$t=0;
$query=("select * from tbl_facilities where status='A'");
	$getQuery = $this->db->query($query);
	
	foreach($getQuery->result() as $res) {
				if($code==$res->fac_code)
						{
							$t=1;
							break;
						}
	
}

echo $t;
?>