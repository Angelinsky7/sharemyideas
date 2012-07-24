<?php

class IdeasController extends Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['ideas'] = Model::factory('Ideas')->order_by_asc('id')->find_many();
		$this->render('ideas/index', $data);
	}

	public function idea($id = null)
	{
		$data['idea'] = Model::factory('Ideas')->find_one($id);
		$data['singleView'] = true;
		$this->render('ideas/single', $data);
	}

	public function save()
	{
		$req = $this->app->request();

		if ($req->isPost()) {
			$p = $req->post();
			$idea = Model::factory('Ideas')->create();
			$idea->title = $p['title'];
			$idea->email = $p['email'];
			$idea->content = $p['idea'];
			$idea->ip_address = $req->getIp();
			$id = $idea->save();
			if ($id) {
				$this->redirect('home');
			}
			$this->app->flashNow('error', 'Your idea was not saved.');
			$this->redirect('home');
		}
	}

	public function allIdeas()
	{
		$photos = array(
			'James' => array('images/home.jpg', 'images/about.jpg'),
			'John' => array('images/dash.jpg', 'images/name.jpg'),
		);

		$this->response($photos);
	}
}