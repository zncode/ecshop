<?php
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');


//获取ERP商品内容
$jsonData 	= file_get_contents("http://www.kiserp.com/categorys");
$categorys 	= json_decode($jsonData);
$count 		= count($categorys);

$output = '<ul>';
$i = 0;
foreach($categorys as $category)
{
	$exist = categorys_erp_exist($category->FItemID);
	if($exist){
		continue;
	}
	$id = insert_categorys($category);
	

	$result = insert_categorys_erp($id, $category->FItemID);
	if($result)
	{
		$parentId 		= $category->FParentID;
		if($parentId){
			$parent_cat_id 	= get_cat_id($parentId);
			update_category_parent($id, $parent_cat_id);			
		}
		$output .= '<li>商品名称: '.$category->FName.' | 商品ID: '.$id.'</li>';
	}
	$i++;
	clear_cache_files();    // 清除缓存
}

$output .= '<ul>';
$output .= '<p>本次导入商品分类总数: '.$i . '</p>';
echo $output;

function insert_categorys($category)
{
	global $ecs, $db;

	$keyStr 	= 'cat_name, keywords, cat_desc, parent_id, sort_order, template_file, measure_unit, show_in_nav, style, is_show, grade, filter_attr';
	$valueStr	= "'{$category->FName}','','',0,99,'','',0,0,1,0,''";

	$table		= $ecs->table('category');
	$sql 		= "INSERT INTO {$table} ($keyStr) VALUES ({$valueStr});";

	//执行
	$db->query($sql);

	/* 商品编号 */
	$products_id = $db->insert_id();
	return $products_id;
}

function insert_categorys_erp($category_id, $erp_id)
{
	global $ecs, $db;
	$table		= $ecs->table('category_erp');
	$sql 		= "INSERT INTO {$table} (cat_id, FItemID) VALUES ({$category_id}, {$erp_id});";

	//执行
	$result = $db->query($sql);	
	if($result){
		return true;
	}else{
		return false;
	}
}

function categorys_erp_exist($erp_id){
	global $ecs, $db;
	$table		= $ecs->table('category_erp');
	$sql 		= "SELECT id from {$table} WHERE FItemID = {$erp_id}";

	//执行
	$result = $db->query($sql);	
	$row = $db->fetchRow($result);

	if($row['id'])
	{
		return true;
	}else{
		return false;
	}
}

function get_cat_id($FItemID)
{
	global $ecs, $db;
	$table	= $ecs->table('category_erp');
	$sql 	= "SELECT cat_id from {$table} WHERE FItemID = {$FItemID}";

	//执行
	$result = $db->query($sql);	
	$row = $db->fetchRow($result);	

	return $row['cat_id'];
}

function update_category_parent($cat_id, $parentId)
{
	global $ecs, $db;
	$table	= $ecs->table('category');
	$sql 	= "UPDATE {$table} SET parent_id = {$parentId} WHERE cat_id = {$cat_id} ";

	//执行
	$db->query($sql);	
}