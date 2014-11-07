<?php
class NewsController extends WebController {

    /**
     * 新建大类
     */
    public function actionAddParent() {
        $params = $this->params();
        $model = NewsCategoryForm::instance();
        $tips = false;
        if (isset($_POST['NewsCategoryForm'])) {
            $model->attributes = $_POST['NewsCategoryForm'];
            if ($model->validate()) {
                $newsCategory = NewsCategory::instance();
                $newsCategory->attributes = $model->attributes;
                $newsCategory->creater = '11';

                $newsCategory->save();
                $tips = true;
            }
        }
        $this->render('add_parent', array('model' => $model, 'tips' => $tips));
    }

    /**
     * 新闻类别列表
     */
    public function actionList() {
        $topCategories = NewsCategory::model()->getTopCategory();
        $this->render('list', array('topCategories' => $topCategories));
    }

    /**
     *  新建子分类
     */
    public function actionAddSub($id) {
        $model = new NewsCategoryForm;
        $category = NewsCategory::model()->findByPk($id);
        if (isset($_POST['NewsCategoryForm'])) {
            $model->attributes = $_POST['NewsCategoryForm'];
            if ($model->validate()) {
                $newsCategory = new NewsCategory;
                $newsCategory->attributes = $model->attributes;
                $newsCategory->code = $category->id;
                $newsCategory->created = time();
                $newsCategory->creater = '11';
                $newsCategory->save();
                $this->redirect($this->createUrl('/news/list'));
            }
        }
        $this->render('add_sub', array('model' => $model, 'category' => $category));
    }

    /**
     * 删除分类
     */
    public function actionDel($id) {
        $category = NewsCategory::model()->findByPk($id);
        $category->delete();
        $this->redirect($this->createUrl('/news/list'));
    }

    /**
     * 添加新闻
     */
    public function actionAddNew($id){
        $category = NewsCategory::model()->findByPk($id);
        $model = new NewsInfoForm;
        $tips = false;
        if (isset($_POST['NewsInfoForm'])) {
            $model->attributes = $_POST['NewsInfoForm'];
            if ($model->validate()) {
                $newsInfo = new NewsInfo;
                $newsInfo->attributes = $model->attributes;
                $newsInfo->pid = $id;
                $newsInfo->created = time();
                $newsInfo->creater = '11';
                $newsInfo->save();
                $tips = true;
            }
        }
        $this->render('add_new', array('category' => $category, 'model' => $model, 'tips' => $tips));
    }

    /**
     * 编辑新闻
     */
    public function actionEditNew($id) {
        $model = new NewsInfoForm;
        $newsInfo = NewsInfo::model()->findByPk($id);
        $model->attributes = $newsInfo->attributes;
        $tips = false;
        if (isset($_POST['NewsInfoForm'])) {
            $model->attributes = $_POST['NewsInfoForm'];
            if ($model->validate()) {
                $newsInfo->attributes = $model->attributes;
                $newsInfo->save();
                $tips = true;
            }
        }
        $this->render('edit_new', array('model' => $model, 'tips' => $tips));
    }

    /**
     * 我的新闻
     */
    public function actionMyList() {
        $newsInfos = NewsInfo::model()->findAll();
        $this->render('my_list', array('newsInfos' => $newsInfos));
    }

    /**
     * 新闻展示
     */
    public function actionView($id) {
        $newsInfo = NewsInfo::model()->findByPk($id);
        if (!$newsInfo) {
            throw new CHttpException(404,'此页面不存在');
        }
        $this->render('view', array('newsInfo' => $newsInfo));
    }

    /**
     * 删除新闻
     */
    public function actionDelNew($id) {
        $newsInfo = NewsInfo::model()->findByPk($id);
        $newsInfo->delete();
        $this->redirect($this->createUrl('/news/mylist'));
    }
}