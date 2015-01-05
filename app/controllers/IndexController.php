<?php

/**
 * This is the main controller that the user accesses when the application is first loaded
 *
 */
class IndexController extends BaseController
{

    /**
     * Define the main layout used to display that controller's view
     *
     * @var string
     */
    protected $layout = 'layouts.default';

    /**
     * Show the index controller view.
     *
     * @return Response
     */
    public function index()
    {
        $this->layout->content = View::make('pages.index');
    }
    
}
