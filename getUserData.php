<?php 
// 获取用户的其他信息，如订单，评价，房源，收藏，故事
	header("Access-Control-Allow-Origin:*");
	include("config.php");

	$userid = $_GET["userid"];
	$collections = $_GET["collections"];

	// 获取用户订单，评价，房源，故事
	$arr = array("story","comment","house","orders");
	$data = array();
	foreach($arr as $value){ 
		$sql = "select * from $value where userid=".(int)$userid;
		$res = mysql_query($sql);
		$json = array();
		if(mysql_num_rows($res) > 0){//数据获取成功
			while ($row = mysql_fetch_array($res,MYSQL_ASSOC))
			{
				array_push($json,json_encode($row));//把数据转换为JSON数据.
			}
		}
		$data["$value"] = json_encode($json);
	}

	// 获取收藏的房源数据
	$collections = explode(',',$collections);
	$sqlCol = "select * from house where";
	foreach($collections as $value) {
		$sqlCol = $sqlCol." houseid=".$value." or";
	}
	$sqlCol = substr($sqlCol,0,-3);//截取掉最后3个字符
	$res = mysql_query($sql);
	$json = array();
	if(mysql_num_rows($res) > 0){//数据获取成功
		while ($row = mysql_fetch_array($res,MYSQL_ASSOC))
		{
			array_push($json,json_encode($row));//把数据转换为JSON数据.
		}
	}
	$data["collection"] = json_encode($json);

	echo json_encode(array(
			"res_code"=>1,
			"res_message"=>"数据查询成功",
			"res_data"=>$data
		));
 ?>