<?php
	//获取数据库连接
	$db = new PDO('mysql:host=localhost;dbname=penson;charset=utf8','root','123456');
	//定义每页查询条数
	$pageSize = 3;
	//获取页面传来的页数，如果为空赋初始值为1
	$pageNum = (int)($_GET['pageNum'] ?? 1);
	//查询分页语句
	$sql = "select * from sheng limit ".($pageNum-1) * $pageSize .','.$pageSize;
	$stmt = $db->prepare($sql);
	$stmt->execute();
	//获取查询结果
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	//定义按钮返回页面
	$upPage = "";
	$lwPage = "";
	//判断第一页,成立上一页不可点击
	if($pageNum <= 1){
		$upPage = "<button pageNum='1' disabled='bisabled'>上一页</button>";
	}else{
		$upPage = "<button pageNum='".($pageNum-1)."'>上一页</button>";
	}
	//查询总记录数
	$sumSql = "select count(*) from sheng";
	$stmt = $db->prepare($sumSql);
	$stmt->execute();
	//获取查询结果
	$count = $stmt->fetchColumn();
	//获取最大页数
	$maxPage = round($count/$pageSize);
	//判断最后一页不可点击
	$pageNum >= $maxPage? $lwPage = "<button pageNum='{$pageNum}' disabled='disabled'>下一页</button>" : $lwPage = "<button pageNum='".($pageNum+1)."'>下一页</button>"; 
	//按钮拼接
	$button = $upPage . $lwPage;
	//已json形式返回查询到的数据与按钮
	$result = [$data,$button];
	echo json_encode($result);
	