<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parts\Button;

class AdminBaseController extends AbstractAdminController
{
    protected $models = [];
    protected $formClass;
    protected $pageTitle;
    protected $pageSubtitle;
    protected $actions = ['index', 'create', 'store', 'edit', 'update', 'delete', 'index_json', 'sort', 'sort_update'];
    protected $routes = [];
    protected $routeName;
    protected $baseRouteParams = [];

    public function __construct()
    {
        parent::__construct();
    }

    protected function initRoutes()
    {
        foreach($this->actions as $action) {
            $this->routes[$action] = $this->routeName . '.' . $action;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $endpoint = route($this->routes['index_json']);
        $columns = $this->getListDataTableColumns();

        if((string)$this->pageSubtitle !== '') {
            $this->pageSubtitle = ' | ' . $this->pageSubtitle . ' | 一覧';
        } else {
            $this->pageSubtitle = ' | 一覧';
        }

        return view('base.list', [
            'columns' => $columns,
            'endpoint' => $endpoint,
            'routes' => $this->routes,
            'pageTitle' => $this->pageTitle,
            'pageSubtitle' => $this->pageSubtitle,
            'buttonSections' => isset($this->buttonSections['index']) ? $this->buttonSections['index'] : [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('base.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('base.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function indexJson(Request $request)
    {
        $results = [];
        $columns = $this->getListDataTableColumns();
        $length = $request->query->getInt('length', 10);
        $start = $request->query->getInt('start', 0);
        $draw = $request->get('draw');
        if($request->has('order')) {
            $order = $request->get('order');
            $orderCol = (int)$order[0]['column'];
            $orderSort = $order[0]['dir'];
        }

        $itemQuery = $this->models['item']::query();
        // $itemQuery->limit($length)->offset($start);
        $items = $itemQuery->get();
        foreach($items as $item) {
            $results[] = $this->toJsonData($request, $item);
        }

        return response()->json([
            'data' => $results,
            "draw" => $draw,
            // "recordsTotal"=> $allCount,
            // "recordsFiltered"=> $filterCount,
        ]);

    }

    protected function toJsonData($request, $model)
    {
        $data = [];
        $columns = $this->getListDataTableColumns();
        foreach($columns as $column) {
            $data[] = $column['callback']($model);
        }

        return $data;
    }

    protected function createDataTableColumns()
    {
        $columns = [];

        $columns[] = [
            'heading'   => 'ID',
            'options'  => [
                'width' => '',
            ],
            'callback' => function($model) {
                return $model->id;
            },
            'order_by' => function($dir, $query) {
                return $query->orderBy('id', $dir);
            }
        ];

        $columns[] = [
            'heading'   => 'タイトル',
            'options'  => [
                'width' => '',
            ],
            'callback' => function($model) {
                return $model->title;
            },
            'order_by' => function($dir, $query) {
                return $query->orderBy('title', $dir);
            }
        ];

        return $columns;
    }

    protected function createDataTableButtons($columns = [])
    {
        $parameters = $this->baseRouteParams;

        $columns[] = [
            'heading'   => '',
            'options'  => [
                'width' => '50px',
                'sClass' => 'center',
                'sortable' => false,
            ],
            'callback' => function($model) use($parameters) {
                $parameters = array_merge($parameters, ['id' => $model->id]);
                return '<a href="'.route($this->routes['edit'], $parameters).'" class="btn btn-sm btn-primary btn-block">編集</a>';
            }
        ];

        $columns[] = [
            'heading'   => '',
            'options'  => [
                'width' => '50px',
                'sClass' => 'center',
                'sortable' => false,
            ],
            'callback' => function($model) {
                return sprintf('<button type="button" class="btn btn-sm btn-danger btn-block" onclick="deleteItem(\'%s\');">削除</button>', $model->id);
            }
        ];

        return $columns;
    }

    protected function getListDataTableColumns()
    {
        $columns = [];

        foreach($this->createDataTableColumns() as $dataColumn) {
            $columns[] = $dataColumn;
        }

        foreach($this->createDataTableButtons() as $button) {
            $columns[] = $button;
        }

        return $columns;
    }

    protected function initButtons()
    {
        $sections['index']['top_left'] = new Button();
        $sections['index']['top_left']->addButton('create', '<i class="far fa-plus-square"></i> 新規作成', [
            'href' => route($this->routes['create']),
            'class' => 'btn btn-primary',
        ]);

        $this->buttonSections = $sections;
    }
}
