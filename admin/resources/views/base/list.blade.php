<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', 'Dashboard')

<!-- ページの見出しを入力 -->
@section('content_header')
    <h1>{{ $pageTitle }}<span>{{ $pageSubtitle }}</span></h1>
@stop

<!-- ページの内容を入力 -->
@section('content')
<div class="card">
    <div class="card-body">
        @if(isset($buttonSections['top_left']) && !$buttonSections['top_left']->isEmpty())
            <div class="">
                @include('elements.button-section', ['section' => $buttonSections['top_left']])
            </div>
        @endif

        <table id="dataTable" class="table table-bordered">
            <thead>
                @foreach($columns as $column)
                    <th>{{ $column['heading'] }}</th>
                @endforeach
            </thead>
            <tbody>
            </tbody>
        </table>    
    </div>
</div>

@php
$columnList=[];
foreach($columns as $index => $column) {
    $columnItem = new stdClass();
    $columnItem->data = $index;
    $options = isset($column['options']) ? $column['options'] : [];
    foreach($options as $key => $value) {
        $columnItem->{$key} = $value;
    }

    $columnList[] = $columnItem;
}
@endphp
@stop

<!-- 読み込ませるCSSを入力 -->
@section('css')
@stop

<!-- 読み込ませるJSを入力 -->
@section('js')
<script>
$(function() {
    let columns = JSON.parse('<?php echo json_encode($columnList) ?>');
    console.log(columns);
    $("#dataTable").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Japanese.json",
            processing: '<span>データ取得中...<i class="fa fa-spinner fa-pulse"></i></span>',
            lengthMenu: "表示件数 : _MENU_",
            zeroRecords: "データ無し",
            info: " _TOTAL_ 件中 _START_ 件から _END_ 件まで表示",
            infoEmpty: " 表示可能なデータが存在しませんでした",
            infoFiltered: "（全 _MAX_ 件より抽出）",
            infoPostFix: "",
            search: "検索:",
            paginate: {
                first: "先頭",
                previous: "前へ",
                next: "次へ",
                last: "最終"
            },
        },
        responsive: true,
        searching: false,
        paging: true,
        dom: '<"top"<"table-top-up"Bl><"table-top-under"ip>>rt<"bottom"p><"clear">',
        "ajax": {
            url: `{{ $endpoint }}`,
        },
        columns : columns,
    }).on( 'error.dt', function ( e, settings, techNote, message ) {
    console.log( 'Error: Calendar DataTables: ' + message ); // for test purpose
    return true;
    });
});
</script>
@stop