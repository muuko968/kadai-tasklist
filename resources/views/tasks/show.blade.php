@extends('layouts.app')

@section('content')

<!-- ここにページ毎のコンテンツを書く -->
<h1>id = {{ $task->id }} の詳細ページ</h1>

    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <td>{{ $task->id }}</td>
        </tr>
        <tr>
            <th>ステータス</th>
            <td>{{ $task->status }}</td>
        </tr>
        <tr>
            <th>やること</th>
            <td>{{ $task->content }}</td>
        </tr>
        
    </table>
     {{-- 編集ページへのリンク --}}
    {!! link_to_route('tasks.edit', 'このやることを編集', ['task' => $task->id], ['class' => 'btn btn-light']) !!}
    
    {{-- 削除フォーム --}}
    {!! Form::model($task, ['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
        {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}

@endsection