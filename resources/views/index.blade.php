@extends('layouts.app')

@section('content')

<!-- ここにページ毎のコンテンツを書く -->
<h1>メッセージ一覧</h1>

    @if (count($messages) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>やること</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->content }}</td>
                    <td>{{ $task->check }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    @foreach ($messages as $message)
                <tr>
                    {{-- メッセージ詳細ページへのリンク --}}
                    <td>{!! link_to_route('tasks.show', $task->id, ['task' => $task->id]) !!}</td>
                    <td>{{ $task->content }}</td>
                </tr>
    @endforeach
    
    {{-- タスク作成ページへのリンク --}}
    {!! link_to_route('tasks.create', 'タスクの投稿', [], ['class' => 'btn btn-primary']) !!}
    
@endsection