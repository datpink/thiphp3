@extends('layouts.master')
@section('title')
    Create New Room
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Type</label>
            <select name="type_id" class="form-control">
                @foreach ($types as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
        </div>
        <div class="form-group">
            <label>Describe</label>
            <textarea name="describe"cols="30" rows="5" class="form-control">{{ old('describe') }}</textarea>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
