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
                        <h1 class="panel-title">お問い合わせ</h1>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(['route' => ['post.contact.create'], 'method' => 'post']) !!}
                        {{ csrf_field() }}

                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="control-label" for="name">お名前</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            @if($errors->has('name'))
                                <p class="help-block">{{ $errors->first('name') }}</p>
                            @endif
                        </div>
                        <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label class="control-label" for="email">メールアドレス</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            @if($errors->has('email'))
                                <p class="help-block">{{ $errors->first('email') }}</p>
                            @endif
                        </div>
                        <div class="form-group required {{ $errors->has('subject') ? 'has-error' : '' }}">
                            <label class="control-label" for="subject">件名</label>
                            <input type="text" class="form-control" name="subject" value="{{ old('subject') }}">
                            @if($errors->has('subject'))
                                <p class="help-block">{{ $errors->first('subject') }}</p>
                            @endif
                        </div>
                        <div class="form-group required {{ $errors->has('content') ? 'has-error' : '' }}">
                            <label class="control-label" for="content">内容</label>
                            <textarea type="text" class="form-control" name="content" rows="10">{{old('content')}}</textarea>
                            @if($errors->has('content'))
                                <p class="help-block">{{ $errors->first('content') }}</p>
                            @endif
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">確認</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection