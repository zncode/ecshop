<?php
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . '/' . ADMIN_PATH . '/includes/lib_goods.php');
include_once(ROOT_PATH . '/includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);

if ($_REQUEST['act'] == 'up_cat')
{
	//获取ERP商品内容
	$goods_erp = get_goods_erp();

	if(count($goods_erp))
	{
		$i = 1;
		foreach($goods_erp as $key => $value){
			$goods_id 	= $value['goods_id'];
			$FItemID 	= $value['erp_id'];
			$jsonData 	= file_get_contents("http://www.kiserp.com/kis/get_item/".$FItemID);
			$data 		= json_decode($jsonData);
			$FParentID 	= $data[0]->FParentID;
			$FName 		= $data[0]->FName;
			if($FParentID){
				$cat_id 	= get_cat_id($FParentID);
				if($cat_id){
					update_product_category($cat_id, $goods_id);
					echo $FName.', 更新完成!<br>';	
					$i++;					
				}
			}
		}
		echo '<p>本次共更新商品分類总数: '.$i . '</p>';
		die();
	}
}

//获取ERP商品内容
$jsonData 	= file_get_contents("http://www.kiserp.com/kis");
$products 	= json_decode($jsonData);
$count 		= count($products);

$output = '<ul>';
$i = 0;
foreach($products as $product)
{
	$exist = goods_erp_exist($product->FItemID);
	if($exist){
		continue;
	}
	$id = insert_product($product);
	$result = insert_goods_erp($id, $product->FItemID);
	if($result)
	{
		$output .= '<li>商品名称: '.$product->FFullName.' | 商品ID: '.$id.'</li>';
	}
	$i++;
}

$output .= '<ul>';
$output .= '<p>本次导入ERP商品总数: '.$i . '</p>';
echo $output;



function insert_product($product)
{
	global $ecs, $db;

	//生成商品编号
	$max_id     = $is_insert ? $db->getOne("SELECT MAX(goods_id) + 1 FROM ".$ecs->table('goods')) : $_REQUEST['goods_id'];
	$goods_sn   = generate_goods_sn($max_id);

	$params = [
		'goods_name' 			=> 'iphone5',
		'goods_name_style' 		=> 0,
		'goods_sn'				=> $goods_sn,
		'cat_id'				=> 0,
		'brand_id'				=> 0,
		'shop_price'			=> 9999,
		'market_price'			=> '9999',
		'virtual_sales'			=> 100,
		'is_promote'			=> 0,
		'promote_price'			=> 0,
		'promote_start_date'	=> 0,
		'promote_end_date'		=> 0,
		'goods_img'				=> 0,
		'goods_thumb'			=> 0,
		'original_img'			=> 0,
		'keywords'				=> 0,
		'goods_brief'			=> 0,
		'seller_note'			=> 0,
		'goods_weight'			=> 0,
		'goods_number'			=> 0,
		'warn_number'			=> 0,
		'integral'				=> 0,
		'give_integral'			=> 0,
		'is_best'				=> 0,
		'is_new'				=> 0,
		'is_hot'				=> 0,
		'is_on_sale'			=> 1,
		'is_alone_sale'			=> 0,
		'is_shipping'			=> 0,
		'goods_desc'			=> 0,
		'add_time'				=> 0,
		'last_update'			=> 0,
		'goods_type'			=> 0,
		'rank_integral'			=> 0,
		'suppliers_id'			=> 999,
	];
	foreach($params as $key => $value)
	{
		$keys[] = $key;
		$values[] = $value;
	}

	$keyStr 	= implode(',', $keys);
	$valueStr 	= implode(',', $values);
	$valueStr	= "'{$product->FName}',0,'{$goods_sn}',0,0,9999,9999,100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,999";

	$table		= $ecs->table('goods');
	$sql 		= "INSERT INTO {$table} ($keyStr) VALUES ({$valueStr});";

	//执行
	$db->query($sql);

	/* 商品编号 */
	$goods_id = $db->insert_id();
	return $goods_id;
}

function insert_goods_erp($goods_id, $erp_id)
{
	global $ecs, $db;
	$table		= $ecs->table('goods_erp');
	$sql 		= "INSERT INTO {$table} (goods_id, erp_id) VALUES ({$goods_id}, {$erp_id});";

	//执行
	$result = $db->query($sql);	
	if($result){
		return true;
	}else{
		return false;
	}
}

function goods_erp_exist($erp_id){
	global $ecs, $db;
	$table		= $ecs->table('goods_erp');
	$sql 		= "SELECT id from {$table} WHERE erp_id = {$erp_id}";

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

function update_product_category($cat_id, $goods_id)
{
	global $ecs, $db;
	$table	= $ecs->table('goods');
	$sql 	= "UPDATE {$table} SET cat_id = {$cat_id} WHERE goods_id = {$goods_id} ";

	//执行
	$db->query($sql);	
}

function get_goods_erp()
{
	global $ecs, $db;
	$table	= $ecs->table('goods_erp');
	$sql 	= "SELECT * from {$table}";

	//执行
	$query = $db->query($sql);	
	while($result = $db->fetch_array($query)){
		$results[] = $result;
	}	

	return $results;
}