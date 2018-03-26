<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class Experiences extends Model
{

	public function cates(){
		return $this->belongsTo('cates','cateid','id');
	}
}
