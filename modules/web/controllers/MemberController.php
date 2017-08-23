<?php

namespace app\modules\web\controllers;

use app\modules\web\controllers\common\BaseController;
use app\common\services\ConstantMapService;
use app\models\Member;
use yii\helpers\Html;
use app\common\services\UrlService;
use app\models\MemberComments;
use app\models\Order;


class MemberController extends BaseController {
    //会员列表
    public function actionList(){
        $mix_kw = trim($this->get("mix_kw",""));
        $status = intval($this->get("status",ConstantMapService::$status_default));
        $p = intval($this->get("p",1));
        $p = ($p > 0)?$p:1;

        $query = Member::find();

        if($mix_kw){
            $where_nickname = ['LIKE','nickname','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false];
            $where_phone = ['LIKE','phone','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false];
            $query->andWhere(['OR',$where_nickname,$where_phone]);
        }

        if($status > ConstantMapService::$status_default){
            $query->andWhere(['status' => $status]);
        }

        //分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
        //60,60 ~ 11,10 - 1
        $total_res_count = $query->count();
        $total_page = ceil($total_res_count / $this->page_size);

        $list = $query->orderBy(['id' => SORT_DESC])
            ->offset(($p - 1) * $this->page_size)
            ->limit($this->page_size)
            ->all();

        $data = [];

        if($list){
            foreach( $list as $_item ){
                $data[] = [
                    'id' => $_item['id'],
                    'nickname' => Html::encode($_item['nickname']),
                    'phone' => Html::encode($_item['phone']),
                    'sex_desc' => ConstantMapService::$sex_mapping[$_item['sex']],
                    'avatar' => UrlService::buildPicUrl("avatar",$_item['avatar']),
                    'status_desc' => ConstantMapService::$status_mapping[$_item['status']],
                    'status' => $_item['status'],
                ];
            }
        }

        return $this->render('list',[
            'list' => $data,
            'search_conditions' => [
                'mix_kw' => $mix_kw,
                'status' => $status
            ],
            'status_mapping' => ConstantMapService::$status_mapping,
            'pages' => [
                'total_count' => $total_res_count,
                'page_size' => $this->page_size,
                'total_page' => $total_page,
                'p' => $p
            ]
        ]);
    }
    
    //会员详情
    public function actionInfo(){
        $id = intval($this->get("id", 0));
        $reback_url = UrlService::buildWebUrl("/member/list");
        if(!$id){
            return $this->redirect($reback_url);
        }

        $info = Member::find()->where(['id' => $id])->one();
        if(!$info){
            return $this->redirect($reback_url);
        }

        $order_list = Order::find()->where(['member_id' => $id,'status' => [-8,1]])->orderBy(['id' => SORT_DESC])->all();
        $comments_list = MemberComments::find()->where(['member_id' => $id])->orderBy(['id' => SORT_DESC])->all();
        
        return $this->render("info",[
            "info" => $info,
            "order_list" => $order_list,
            'comments_list' => $comments_list
        ]);
    }
    
    //会员编辑与添加
    public function actionEdit(){
        if(\Yii::$app->request->isGet){
            $id = intval($this->get("id", 0));
            $info = [];
            if($id){
                $info = Member::find()->where(['id'=>$id])->one();
            }

            return $this->render('edit',[
                'info' => $info
            ]);
        }

        $id = intval($this->post("id",0));
        $nickname = trim($this->post("nickname",""));
        $phone = trim($this->post("phone",0));
        $date_now = date("Y-m-d H:i:s");

        if(mb_strlen($nickname,"utf-8") < 1){
            return $this->renderJSON([],"请输入符合规范的姓名~~",-1);
        }

        if(mb_strlen($phone,"utf-8" ) < 1){
            return $this->renderJSON([],"请输入符合规范的手机号码~~",-1);
        }

        $info = [];
        if($id){
            $info = Member::findOne(['id' => $id]);
        }
        if($info){
            $model_member = $info;
        }else{
            $model_member = new Member();
            $model_member->status = 1;
            $model_member->avatar = ConstantMapService::$default_avatar;
        }

        $model_member->nickname = $nickname;
        $model_member->phone = $phone;
        $model_member->updated_time = $date_now;
        $model_member->save();
        return $this->renderJSON([],"操作成功~~");
    }
    
    //会员评论列表
    public function actionComment(){

        return $this->render('comment');
    }

    // ajax操作对象
    public function actionOps(){
        if(!\Yii::$app->request->isPost){
            return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
        }

        $id = $this->post('id',[]);
        $act = trim($this->post('act',''));
        if(!$id){
            return $this->renderJSON([],"请选择要操作的会员账号号。",-1);
        }

        if(!in_array( $act,['remove','recover'])){
            return $this->renderJSON([],"操作有误，请重试。",-1);
        }

        $info = Member::find()->where(['id' => $id])->one();
        if(!$info){
            return $this->renderJSON([],"指定会员账号不存在。",-1);
        }

        switch ($act){
            case "remove":
                $info->status = 0;
                break;
            case "recover":
                $info->status = 1;
                break;
        }
        $info->updated_time = date("Y-m-d H:i:s");
        $info->update();
        return $this->renderJSON( [],"操作成功~~" );
    }
}
