<?php

class JobsController extends AppController{

	public $name = 'Jobs';

	public function index(){


		// set category query options
		$options = array(
						'order' => array('Category.name' => 'asc' )
						);

		// get categories
		$categories = $this->Job->Category->find('all', $options);

		// set categories
		$this->set('categories', $categories);

		// set query options
		$options = array(
					'order' => array('Job.created' => 'desc'),
					'limit' => 10
						);

		// get job info
		$jobs = $this->Job->find('all', $options);


		// set title
		$this->set('title_for_layout', 'GetHired | Welcome');

		$this->set('jobs',$jobs);

	}



	public function browse($category = null){


		// initialize conditions array
		$conditions = array();


		// check keyword filter
		if($this->request->is('post')){

			if(!empty($this->request->data('keywords'))){

				$conditions[] = array('OR' => array(
								'Job.title LIKE' => "%" . $this->request->data('keywords') . "%" , 
								'Job.description LIKE' => "%" . $this->request->data('keywords') . "%" 
								));
			}
		}


		// check state filter
		if(!empty($this->request->data('state')) && $this->request->data('state') != 'Select State'){

			// match state
			$conditions[] = array(
								'Job.state LIKE' => "%" . $this->request->data('state') . "%"
								);
		}


		// check category filter
		if(!empty($this->request->data('category')) && $this->request->data('category') != 'Select Category'){

			// match category
			$conditions[] = array(
								'Job.category_id LIKE' => "%" . $this->request->data('category') . "%"
								);
		}



		// set category query options
		$options = array(
						'order' => array('Category.name' => 'asc' )
						);

		// get categories
		$categories = $this->Job->Category->find('all', $options);

		// set categories
		$this->set('categories', $categories);


		

		if($category != null){

			// match category
			$conditions[] = array(
								'Job.category_id LIKE' => "%" . $category . "%"
								);
		}

		// set query options
		$options = array(
						'order' => array('Job.created' => 'desc'),
						'conditions' => $conditions,
						'limit' => 8
						);

		// get job info
		$jobs = $this->Job->find('all', $options);


		// set title
		$this->set('title_for_layout', 'GetHired | Browse Job');

		$this->set('jobs',$jobs);

	}



	// view a partiular job detail in a single view
	public function view($id){

		if(!$id){

			throw new NotFoundException(__('Invalid Job Listing'));
			
		}

		$job = $this->Job->findById($id);

		if(!$job){

			throw new NotFoundException(__('Invalid Job Listing'));
		}

		// set title
		$this->set('title_for_layout', $job['Job']['title']);

		$this->set('job', $job);
	}



	// add job

	public function add(){

		// get categories for select list
		$options = array(
						'order' => array('Category.name' => 'asc')
						);

		// get categories
		$categories = $this->Job->Category->find('list', $options);

		// set categories
		$this->set('categories', $categories);

		// get type for select list
		$types = $this->Job->Type->find('list');

		// set type
		$this->set('types', $types);



		if($this->request->is('post')){

			$this->Job->create();

			// save logged user ID
			$this->request->data['Job']['user_id'] = $this->Auth->user('id');

			if($this->Job->save($this->request->data)){

				$this->Session->setFlash(__('Your job has been listed'));
				return $this->redirect(array('action' => 'index'));

			}

			$this->Session->setFlash(__('Unable to add your job'));

		}
	}




	// edit job

	public function edit($id){

		// get categories for select list
		$options = array(
						'order' => array('Category.name' => 'asc')
						);

		// get categories
		$categories = $this->Job->Category->find('list', $options);

		// set categories
		$this->set('categories', $categories);

		// get type for select list
		$types = $this->Job->Type->find('list');

		// set type
		$this->set('types', $types);

		if(!$id){

			throw new NotFoundException(__('Invalid job listing'));
		}

		$job = $this->Job->findById($id);

		if(!$job){

			throw new NotFoundException(__('Invalid job listing'));
		}



		if($this->request->is(array('job','put'))){

			$this->Job->id = $id;

		

			if($this->Job->save($this->request->data)){

				$this->Session->setFlash(__('Your job has been updated'));
				return $this->redirect(array('action' => 'index'));

			}

			$this->Session->setFlash(__('Unable to update your job'));

		}


		if(!$this->request->data){

			$this->request->data = $job;
		}
	}



	// delete a job

	public function delete($id){

		if($this->request->is('get')){

			throw new MethodNotAllowedException();

		}

		if($this->Job->delete($id)){

			$this->Session->setFlash(__('The job with id: %s has been deleted.', h($id)));

			return $this->redirect(array('action' => 'index'));
		
		}



	}




}