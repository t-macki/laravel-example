@extends('layouts.app')

@section('title', 'お問い合わせ')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="panel-title">お問い合わせ確認</h1>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(['route' => ['post.contact.store'], 'method' => 'post']) !!}
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="control-label" for="name">お名前</label>
                            <p class="form-control-static">{{ $data['name'] }}</p>
                            <input type="hidden" name="name" value="{{ $data['name'] }}">
                            @if($errors->has('name'))
                                <p class="help-block">{{ $errors->first('name') }}</p>
                            @endif
                        </div>
                        <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label class="control-label" for="email">メールアドレス</label>
                            <p class="form-control-static">{{ $data['email'] }}</p>
                            <input type="hidden" name="email" value="{{ $data['email'] }}">
                            @if($errors->has('email'))
                                <p class="help-block">{{ $errors->first('email') }}</p>
                            @endif
                        </div>
                        <div class="form-group required {{ $errors->has('subject') ? 'has-error' : '' }}">
                            <label class="control-label" for="subject">件名</label>
                            <p class="form-control-static">{{ $data['subject'] }}</p>
                            <input type="hidden" name="subject" value="{{ $data['subject'] }}">
                            @if($errors->has('subject'))
                                <p class="help-block">{{ $errors->first('subject') }}</p>
                            @endif
                        </div>
                        <div class="form-group required {{ $errors->has('content') ? 'has-error' : '' }}">
                            <label class="control-label" for="content">内容</label>
                            <p class="form-control-static">{!! nl2br(e($data['content'])) !!}</p>
                            <input type="hidden" name="content" value="{{ $data['content'] }}">
                            @if($errors->has('content'))
                                <p class="help-block">{{ $errors->first('content') }}</p>
                            @endif
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" name="action" value="post" class="btn btn-primary">送信</button>
                            <button type="submit" name="action" value="back" class="btn btn-default">戻る</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection